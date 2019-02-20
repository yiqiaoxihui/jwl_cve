
import os
import sys
import xml.etree.ElementTree as ET
import requests
import re
import pymysql
import subprocess
import time

global db,cursor

def auto_download_cnvd():
	sums=0
	fail=0
	for i in range(357,532):
		try:
			cmd = 'wget -c http://www.cnvd.org.cn/shareData/download/'+str(i)
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
		patch_description=""
		cnvd_id=item.find("number").text
		try:
			patch_description=item.find("formalWay").text
		except Exception as e:
			print "no find cnvd_formalWay"
		#print patchName
		sql="select * from patchs where cnvd_id='%s'" % cnvd_id
		#print sql
		try:
			status=cursor.execute(sql)
			if status==1:
				sql= "UPDATE patchs SET patch_description='%s'WHERE cnvd_id='%s'" % (patch_description,cnvd_id)
				#print sql
				try:
					cursor.execute(sql)
					db.commit()
					print "update successful!",cnvd_id
				except:
					print "update fail",cnvd_id
					db.rollback()
			else:
				sql = '''INSERT INTO patchs(patch_description,cnvd_id) VALUES ("%s","%s")''' % (patch_description,cnvd_id)
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
