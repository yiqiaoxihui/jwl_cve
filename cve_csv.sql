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
into table cve
fields terminated by ',';

