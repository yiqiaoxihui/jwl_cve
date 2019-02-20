--author heaven
--date 2019/1/5
--说明 将cve漏洞信息批量导入数据库，cve下载链接http://cve.mitre.org/data/downloads/allitems.csv
--使用方法 在数据库中执行 source cve_csv.sql,源文件csv路径需根据位置更改
create database if not exists cve;
use cve;
#cve
-- drop table if exists cve;
-- create table if not exists cve(
--   out_ip varchar(16),
--   protocol varchar(16),
--   primary key (in_ip, out_ip),
--   key in_ip_index (in_ip),
--   key out_ip_index (out_ip)
-- ) engine = MyISAM;

load data local infile '/home/ly/allitems.csv'
into table cves
fields terminated by ',';

