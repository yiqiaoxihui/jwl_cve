#coding=utf8
from bs4 import BeautifulSoup
import requests
import re
import pymysql
import time
headers = {}
headers["User-Agent"] = "Mozilla/5.0 (Windows NT 5.2) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.122 Safari/534.30"
headers["Accept"] = "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
headers["Accept-Language"] = "zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3"
headers["Accept-Encoding"] = "gzip, deflate"
headers["Upgrade-Insecure-Requests"] = "1"
 
def getMiddleStr(content, startStr, endStr):#写一个函数获取网页某个范围的源码
	startIndex = content.index(startStr)
	if startIndex >= 0:
		startIndex += len(startStr)
		endIndex = content.index(endStr)
		#print(endIndex)
		#print(content[startIndex:endIndex])
	return content[startIndex:endIndex]
 
def getCVES():# 获取最新到CVE链接，返回链接的列表
	try:
		url = 'https://cassandra.cerias.purdue.edu/CVE_changes/today.html'
		res = requests.get(url, headers=headers, timeout=60)
		CVEList_html = getMiddleStr(res.text, 'New entries:', 'Graduations')
		soup = BeautifulSoup(CVEList_html, 'html.parser')
		list = []
		for a in soup.find_all('a'):
			uri = a["href"]
			list.append(uri)
			#print(a['href'])
			#print(a.string)
		return list
	except Exception as e:
		print(e)
 
def getCVEDetail(list):
	try:
		db = pymysql.connect("localhost","root","yiqiaoxihui","cve")
		print("连接数据库成功！")
		cursor = db.cursor()
		print("开始采集漏洞信息入库！")
		for uri in list:
			print("\n\n")
			print(uri)
			res = requests.get(uri,headers=headers,timeout=60)
			soup = BeautifulSoup(res.text,"html.parser")
			cve_id = str(soup.find(nowrap="nowrap").find("h2").string)
			table = soup.find(id = "GeneratedTable").find("table")
			cve_description = table.find_all("tr")[3].find("td").string
			Assigning_CNA = table.find_all("tr")[8].find("td").string
			Data_Entry_Created = table.find_all("tr")[10].find("b").string
			cve_phase = table.find_all("tr")[12].find("td").string
			cve_votes = table.find_all("tr")[14].find("td").string
			cve_comments = table.find_all("tr")[16].find("td").string
			s = res.text
			ss = getMiddleStr(s,"References","Assigning CNA")
			urls=re.findall(r"<a.*?href=.*?<\/a>",ss,re.I)
			Reference = []
			for i in urls[1:]:
				Reference.append(i.split(">")[1].split("<")[0])
			cve_references = ",".join(Reference)
			args = (cve_id,cve_description,Assigning_CNA,Data_Entry_Created,cve_references)
			print cve_id,cve_phase
			sql="select * from cves where cve_id='%s'" % cve_id
			print sql
			try:
				status=cursor.execute(sql)
				if status==1:
					sql= "UPDATE cves SET cve_description='%s',cve_references='%s',cve_phase='%s',cve_votes='%s',cve_comments='%s' WHERE cve_id='%s'" % (cve_description,cve_references,cve_phase,cve_votes,cve_comments,cve_id)
					try:
						cursor.execute(sql)
						db.commit()
						print "update successful!",cve_id
					except:
						print "update fail",cve_id
						db.rollback()
				else:
					sql = '''INSERT INTO cves(cve_id,cve_description,cve_status,cve_references,cve_phase,cve_votes,cve_comments) VALUES ("%s","%s","%s","%s","%s","%s","%s")''' % (cve_id,cve_description,"none",cve_references,cve_phase,cve_votes,cve_comments)
					try:
						cursor.execute(sql)
						db.commit()
						print "insert successful!",cve_id
					except:
						db.rollback()
			except:
				print "query successful!",cve_id
		db.close()
		print("漏洞数据采集成功！")
	except Exception as e:
		print(str(e))
 
if __name__ == "__main__":
	while True:
		getCVEDetail(getCVES())
		time.sleep(86400)
