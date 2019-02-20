#coding=utf8
#author		 heaven
#date		 2019/2/1
#脚本描述	 将cnvd漏洞信息导入到数据库中
#脚本使用说明 python swarm_cve.py


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
 
def getMiddleStr(content, startStr, endStr):
	startIndex = content.index(startStr)
	if startIndex >= 0:
		startIndex += len(startStr)
		endIndex = content.index(endStr)
	return content[startIndex:endIndex]
 
def get_cves():# 获取最新到CVE链接，返回链接的列表
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
 
def get_cve_today(list):
	try:
		db = pymysql.connect("localhost","root","yiqiaoxihui","cve")		#连接数据库
		print("连接数据库成功！")
		cursor = db.cursor()
		print("开始采集CVE漏洞信息入库！")
		for uri in list:
			print("\n\n")
			print(uri)
			res = requests.get(uri,headers=headers,timeout=60)			#获取网页源代码
			soup = BeautifulSoup(res.text,"html.parser")				#解析网页标签
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
			for i in urls[1:]:											#提取参考链接
				Reference.append(i.split(">")[1].split("<")[0])
			cve_references = ",".join(Reference)
			print cve_id,cve_phase
			sql="select * from cves where cve_id='%s'" % cve_id 		#先查看是否存在该记录
			print sql													#然后更新/插入
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
				print "query fail!",cve_id
		db.close()
		print("漏洞数据采集成功！")
	except Exception as e:
		print(str(e))
 
if __name__ == "__main__":
	while True:
		get_cve_today(get_cves())
		print "wait for next..."
		time.sleep(86400)
