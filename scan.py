#coding=utf8
import requests
import re
import pymysql
import time
import datetime
import sys
import os
import shlex
import subprocess

global db,cursor

def run_scan(scan_items):
	for key in scan_items:
		cmd = shlex.split(scan_items[key]['cmd'])
		reg=scan_items[key]['reg']
		print "\n\n*****************new scan*****************"
		print cmd
		p = subprocess.Popen(cmd, shell=False, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
		line=""
		status="0"
		scan_result=""
		while p.poll() is None:
			line = p.stdout.readline().strip()
			if line:
				scan_result+=line
				scan_result+="<br>"
		if p.returncode == 0:
			print "scan result:"
			print scan_result.replace("<br>",'\n')
			#line.replace("\r\n","</br>")
			status="1"
			if reg in scan_result:
				bug="1"
			else:
				bug="0"
		else:
			print "scan fail: ",cmd
			status="-1"
			bug="-1"

		now = datetime.datetime.now()
		now = now.strftime("%Y-%m-%d %H:%M:%S")
		sql="update scans set status='%s',scan_result='%s',updated_at='%s',bug='%s' where id='%s'" % (status,scan_result,now,bug,key)
		# print sql
		try:
			cursor.execute(sql)
			db.commit()
			print "update scans successful!",key
		except:
			print "update scans fail",key
			db.rollback()        
def wait():
    s1="wait for next scan."
    s2="wait for next scan.."
    s3="wait for next scan..."
    os.system("clear")
    print s1
    time.sleep(1)
    os.system("clear")
    print s2
    time.sleep(1)
    os.system("clear")
    print s3 
    time.sleep(1)
def main():
	global db,cursor
	db = pymysql.connect("localhost","root","yiqiaoxihui","cve")
	print("连接数据库成功！")
	cursor = db.cursor()
	scan_items={}
	sql="select rules.script_name,rules.script_argv,rules.port,rules.reg,scans.host,scans.id from scans join rules on scans.rule_id = rules.id  where scans.status=0"
	try:
		status=cursor.execute(sql)
		print status
		if status>=1:
			result = cursor.fetchall()
			for item in result:
				if item[2]=="":
					port_arg=" "
				else:
					port_arg=" -p "+item[2]+" "
				scan_items[item[5]]={}
				scan_items[item[5]]['reg']=item[3]
				scan_items[item[5]]['cmd']="nmap "+item[1]+" --script "+item[0]+port_arg+item[4]
				# print scan_items[item[5]]['cmd']

		else:
			print "no scan item"
	except:
		print "query scan item fail!"
	run_scan(scan_items)
	db.close()
if __name__ == '__main__':
	main()
