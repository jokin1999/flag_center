# Flag Center

## API相关

### Actions

- 用户注册： `/registerAccount.php?username=[username]&password=[password]`
- 用户提交Flag： `/checkIn.php?username=[username]&password=[password]&flag=[flag]`

## 数据库设计
```
#用户信息
create table gass_fc_user_accounts(
  uid int unsigned auto_increment primary key not null comment "用户ID",
  username varchar(16) unique not null comment "用户名",
  password varchar(32) not null comment "密码",
  status tinyint not null default 1 comment "状态"
)comment="用户信息",engine=MyISAM default character set utf8 collate utf8_general_ci;

#flag提交信息
create table gass_fc_submissions(
  sid int unsigned auto_increment primary key not null comment "提交ID",
  uid int unsigned not null comment "用户ID",
  flag text not null comment "Flag",
  sub_at datetime not null default now() comment "签到时间",
  status tinyint not null default 1 comment "状态"
)comment="flag提交信息",engine=MyISAM default character set utf8 collate utf8_general_ci;

#flag注册表
create table gass_fc_flags(
  fid int unsigned auto_increment primary key not null comment "Flag ID",
  flag text not null comment "Flag",
  create_at datetime not null default now() comment "创建时间",
  points int not null default 1 comment "分值",
  status tinyint not null default 1 comment "状态"
)comment="flag注册表",engine=MyISAM default character set utf8 collate utf8_general_ci;
```
