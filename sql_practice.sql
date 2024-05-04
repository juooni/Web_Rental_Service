#1. 물품유형
create table 물품유형 (물품유형번호 int primary key auto_increment,
                 물품명 char(10),
                 수량 int
                 보관위치 char(10)) engine=InnoDB;

#2. 물품
create table 물품 (물품번호 int primary key auto_increment,
                   물품상태 char(10)  default '대여가능', 
                   물품유형번호 int,
                   foreign key (물품유형번호) referneces 물품유형(물품유형번호)
                        on delete cascade ) engine=InnoDB;

#3. 고객
create table 고객 (고객번호 int primary key auto_increment,
                 고객이름 char(10) ,
                 연락처 char(30)) engine=InnoDB;

#4. 대여
create table 대여 (대여번호 int primary key auto_increment,
                 대여일자 date,
                 대여자이름 char(10),
                 대여자연락처 char(30),
                 대여담당자이름 char(10),
                 고객번호 int,
                 foreign key (고객번호) references 고객(고객번호)) engine=InnoDB;

#5. 대여물품
create table 대여물품(대여물품번호 int primary key auto_increment,
                  반납예정일 date,
                  반납여부 char(10) default '반납안됨',
                  반납담당자이름 char(10) default '미정',
                  물품번호 int, 
                  대여번호 int, 
                  foreign key (물품번호) references 물품(물품번호)
                  foreign key (대여번호) references 대여(대여번호)
                        on delete cascade ) engine=InnoDB;


# 물품유형 insert
#insert into 물품유형(물품명, 수량, 보관위치) values(접이식테이블, 6, 창고)
#insert into 물품(물품유형번호) values(1)  6번

#insert into 물품유형(물품명, 수량, 보관위치) values(의자, 10, 창고)
#insert into 물품(물품유형번호) values(2)  10번

#insert into 물품유형(물품명, 수량, 보관위치) values(천막, 2, 창고)
#insert into 물품(물품유형번호) values(3)  2번

#insert into 물품유형(물품명, 수량, 보관위치) values(손수레, 4, 창고)
#insert into 물품(물품유형번호) values(4)  4번

#insert into 물품유형(물품명, 수량, 보관위치) values(앰프, 3, 사무실)
#insert into 물품(물품유형번호) values(5)  3번

#insert into 물품유형(물품명, 수량, 보관위치) values(프로젝터 스크린, 2, 창고)
#insert into 물품(물품유형번호) values(6)  2번
                              
#insert into 물품유형(물품명, 수량, 보관위치) values(유선마이크, 3, 사무실)
#insert into 물품(물품유형번호) values(7)  3번
                              
#insert into 물품유형(물품명, 수량, 보관위치) values(빔프로젝터, 1, 창고)
#insert into 물품(물품유형번호) values(8)  1번

insert into 물품유형(물품명, 수량, 보관위치) values(철이젤, 5, 사무실)
insert into 물품(물품유형번호) values(9)  5번
                              
insert into 물품유형(물품명, 수량, 보관위치) values(나무이젤, 1, 창고)
insert into 물품(물품유형번호) values(10)  1번
                              
insert into 물품유형(물품명, 수량, 보관위치) values(돗자리, 3, 창고)
insert into 물품(물품유형번호) values(11)  3번