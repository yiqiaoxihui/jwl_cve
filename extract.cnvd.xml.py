
import os
import sys
import xml.etree.ElementTree as ET
import requests
import re
import pymysql

def main():
	file_path=sys.argv[1]
	print file_path
	try:
		db = pymysql.connect("localhost","root","yiqiaoxihui","cve")
		print("connect mysql successful")
		cursor = db.cursor()
	except Exception as e:
		print e
	tree = ET.parse(file_path)
	root = tree.getroot()
	print root.tag
	print root.attrib
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
		print sql
		try:
			status=cursor.execute(sql)
			if status==1:
				sql= "UPDATE cnvds SET cnvd_title='%s',cnvd_description='%s',cnvd_serverity='%s',cnvd_products='%s',cnvd_formalWay='%s',cnvd_patch='%s',cnvd_submitTime='%s' WHERE cnvd_id='%s'" % (cnvd_title,cnvd_description,cnvd_serverity,cnvd_products,cnvd_formalWay,cnvd_patch,cnvd_submitTime,cnvd_id)
				print sql
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
	db.close()
if __name__ == '__main__':
	main()
