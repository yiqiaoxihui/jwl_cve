#author		 heaven
#date		 2019/2/3
#脚本描述	 将cnvd漏洞信息导入到数据库中
#脚本使用说明 python patch_to_mysql.py 文件所在的目录

import os
import sys
import xml.etree.ElementTree as ET
import requests
import re
import pymysql
import subprocess
import time
import os

global db,cursor

def auto_download_cnvd(file_dir):
	sums=0
	fail=0
	try:
		os.makedirs(file_dir)
	except Exception as e:
		raise e
	for i in range(357,532):
		try:
			cmd = 'wget -P '+file_dir+'-c http://www.cnvd.org.cn/shareData/download/'+str(i)
			print cmd
			#print "begin"
			status = subprocess.call(cmd,shell=True)
			if status !=0:
				fail+=1
				print "Download  failed:"+i
			else:
				sums+=1
				print "Download success:"+i
		except:
		    print "Download except!"
	print sums,fail


def deal_mutil_file(file_dir):
	list_dir = os.listdir(file_dir)
	for file in list_dir:
		if True:			#file[-4:]==".xml":
			try:
				print file
				parse_and_insert(file_dir+"/"+file)
			except Exception as e:
				print e,file

def parse_and_insert(file_path):
	tree = ET.parse(file_path)
	root = tree.getroot()
	#print root.tag
	#print root.attrib
	for item in root.findall('vulnerability'):
		patchName=""
		cnvd_formalWay=""
		cnvd_patch=""
		description=""
		cnvd_id=item.find("number").text
		cnvd_serverity=item.find("serverity").text
		cnvd_title=item.find("title").text
		cnvd_products=""
		try:
			for p in item.find("products").iter('product'):
				cnvd_products=cnvd_products+p.text+" | "
			if cnvd_products!="":
				cnvd_products=cnvd_products[:-1]
		except Exception as e:
			print "no find cnvd_products"
		#print cnvd_products
		try:
			cnvd_description=item.find("description").text
		except Exception as e:
			print "no find cnvd_description"
		#products=item.find("products").text
		try:
			cnvd_formalWay=item.find("formalWay").text
		except Exception as e:
			print "no find cnvd_formalWay"
		try:
			cnvd_patch=item.find("patchName").text
		except Exception as e:
			print "no find cnvd_patch"
		cnvd_submitTime=item.find("submitTime").text
		#print patchName
		sql="select * from cnvds where cnvd_id='%s'" % cnvd_id
		#print sql
		try:
			status=cursor.execute(sql)
			if status==1:
				sql= "UPDATE cnvds SET cnvd_title='%s',cnvd_description='%s',cnvd_serverity='%s',cnvd_products='%s',cnvd_formalWay='%s',cnvd_patch='%s',cnvd_submitTime='%s' WHERE cnvd_id='%s'" % (cnvd_title,cnvd_description,cnvd_serverity,cnvd_products,cnvd_formalWay,cnvd_patch,cnvd_submitTime,cnvd_id)
				#print sql
				try:
					cursor.execute(sql)
					db.commit()
					print "update successful!",cnvd_id
				except:
					print "update fail",cnvd_id
					db.rollback()
			else:
				sql = '''INSERT INTO cnvds(cnvd_title,cnvd_description,cnvd_serverity,cnvd_products,cnvd_formalWay,cnvd_patch,cnvd_submitTime,cnvd_id) VALUES ("%s","%s","%s","%s","%s","%s","%s","%s")''' % (cnvd_title,cnvd_description,cnvd_serverity,cnvd_products,cnvd_formalWay,cnvd_patch,cnvd_submitTime,cnvd_id)
				try:
					cursor.execute(sql)
					db.commit()
					print "insert successful!",cnvd_id
				except:
					db.rollback()
		except Exception as e:
			print e

def main():
	file_dir=sys.argv[1]
	# auto_download_cnvd(file_dir)
	global db,cursor
	try:
		db = pymysql.connect("localhost","root","yiqiaoxihui","cve")
		print("connect mysql successful")
		cursor = db.cursor()
	except Exception as e:
		print e
	
	deal_mutil_file(file_dir)
	try:
		db.close()
	except Exception as e:
		raise e
if __name__ == '__main__':
	main()
