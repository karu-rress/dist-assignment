# 전자정보 보안기술  
  \
**중앙대학교 산업보안학과 1학년**  
**20234748 나선우**
  
전자정보 보안기술 과제입니다.

`Readme.txt`에 동일한 내용이 재구성되어 작성되었습니다. (과제 제출용)

## 파일 소개
`runme.exe` 파일을 통해 컴퓨터에 데이터베이스를 구축할 수 있습니다.\
`runme.exe -i` 을 통해 `library` DB를 설정하고 계정을 생성합니다.\
이때 화면에 표시된 명령어를 모두 복사 및 붙여넣기해야 합니다.\
`runme.exe -r` 을 통해 `library_db.sql` 파일에서 `library` DB의 내용을 불러옵니다.
  \
`runme.exe -b` 을 통해 데이터베이스를 백업할 수 있습니다.

    .                 // runme.exe, index.html, library_db.sql, readme.md 등
    ├───account       // 사용자가 접근하는 계정 관련 페이지입니다.
    ├───books         // 사용자가 접근하는 책 관련 페이지입니다.
    ├───db            // 데이터베이스를 처리하는 PHP 파일들입니다.
    ├───htmls         // html 코드 조각입니다.
    ├───manage        // 관리자가 접근하는 페이지입니다.
    ├───resources     // 웹페이지에 삽입되는 사진 등 리소스 파일들입니다.
    ├───scripts       // TypeScript로 작성된 파일들입니다.
    │   └───js        // TypeScript를 컴파일한 JavaScript 결과물입니다.
    └───styles        // CSS 파일들입니다.

20234748.sql 파일과 library_db.sql 파일은 내용이 동일합니다.\
과제 제출 조건을 만족하기 위해 학번으로 된 파일을 따로 생성하였으며,\
`runme.exe` 파일에서는 library_db.sql 파일을 사용하기에 동일한 파일을\
생성하였습니다.

## 웹페이지 소개

- 본 페이지에서는 데이터베이스에 저장된 도서 목록을 확인하고, 대출할 수 있습니다.  
- 회원가입 및 로그인이 가능하며, 비밀번호는 SHA-256으로 암호화되어 저장됩니다.  
- 사용자 계정으로 로그인한 경우, 도서 대출 및 반납이 가능합니다.  
- 고급 검색 기능을 제공하며, AND 및 OR 조건으로 검색이 가능합니다.  
- admin 계정으로 접속시 도서의 정보 및 대출 상태를 관리할 수 있습니다.  
- - admin의 경우 각 도서를 클릭하면 나타나는 상세 페이지에서 관리자<->사용자 모드를 전환할 수 있습니다.
- 새로 들어온 도서 목록을 제공하며, 최신순으로 상위 50%의 도서를 보여줍니다.

## 심미성 및 추가 기능 소개
- footer를 하단에 고정하여 일관성 있는 디자인을 완성했습니다.
- 마이페이지에서 체크박스를 통해 대출한 도서를 일괄 반납할 수 있습니다.
- '새로 들어온 도서' 에서는 SubQuery를 이용하여 도서 중 상위 50% 이내로 일찍 들어온 도서를 나열합니다.
- 각 책의 상세페이지에서는 LEFT JOIN을 이용하여 추가 정보를 출력합니다.
- 동일한 페이지 내에서 PHP를 이용해 Guest/User/Admin의 기능을 구분했습니다(/books/listall.php 등)
- 검색창에서 Radio Button을 이용하여 AND, OR 검색 옵션을 지정할 수 있습니다.
- CSS를 활용하여 심미성을 강조한 표 디자인을 완성했고, 마우스 포인터가 올려진 셀이 강조됩니다.

## 보안 관련 기능 소개
- mysqli 함수를 직접 사용하지 않고, 객체를 생성하여 매개변수를 바인딩하는 형식으로 SQL Injection 취약점을 보완했습니다.
- 기본적으로 bind_param() 메서드를 사용하나, 검색 환경과 같이 파라미터가 가변적인 경우에는 해당 함수를 사용할 수 없습니다.
- 이에, 이곳에서는 예외적으로 TypeScript(JavaScript)/PHP를 활용하여 Client-/Server-Side 모두에서 SQL Injection에 사용되는 특수문자를 걸러내는 방식으로 동작합니다.
- 허가되지 않은 사용자가 권한이 없는 페이지에 접속할 경우 403 Error를 내며 연결이 차단됩니다.
- COOKIE를 이용하여 Client-및 Server-side에서 사용자 정보를 관리합니다.
- 주소창에 적절하지 않은 ISBN을 입력한 경우 404 Error를 내며 접속을 차단합니다.
- root 계정을 사용하지 않고 새로운 server 계정을 사용하여 꼭 필요한 권한 외 다른 권한을 제거하였습니다.
- 모든 계정의 비밀번호는 SHA-256으로 안전하게 암호화되어 저장됩니다.
  
# 과제 공지사항

## 채점기준
1. 기본적으로 아래 요구/주의 사항을 잘 지키면 100점
- [X] 최소한의 심미성 (페이지 구성, 폰트 크기, 색상, 위치 등)을 지키면 감점 없음
- [X] 각 기능(데이터 삽입/수정/삭제/로그인/대여 또는 판매 여부 등) 별로 동작 (DB와의 연동) 여부 확인하여 미비한 부분에 대한 감점
- [X] 데이터베이스 백업이 잘못된 경우 DB 파트 '0'점 처리되니 백업 후 반드시 테스트한 이후에 제출할 것 (테이블 구조 - create문, 실데이터 - insert 문)
- [X] 제공된 Baseline 코드와 수업 시간에 다룬 기본 APM(아파치,PHP, MySQL) 기능 만을 이용한 경우가 아니라, 서버 설정이나 구성에 있어 꼭 필요한 내용이 있으면 반드시 Readme.txt 파일에 작성해서 함께 제출할 것.

2. 가산점 (10점)
- [X] 심미성 (단순하게 몇 개체에 CSS를 적용한 것이 아닌): 전체적으로 웹 어플리케이션의 완성도를 높이는데 기여했다고 판단했을 경우
- [X] 보안: 보안 취약점 대처 방안
- [X] 이외에 기본적으로 요구되는 기능이 포함되는 최소한의 페이지가 아닌 (단순히 페이지 수 늘리기가 아닌) 다양한 기능 구현 (포인트 적립, 우수고객 관리, 회원관리-취향?등에 대한 개인관리 등)
- [X] Readme.txt 파일에 본인의 웹 애플리케이션에서 보안 취약점들을 위한 대처 방안에 대해 어떤 고민을 하고 기능을 구현 하였는지에 대해 함께 기술

## 주제

- [ ] 티켓(영화, 공연 등) 예매 사이트
- [X] 도서 대여 사이트
- [ ] 학사 관리 사이트

개인 과제이며, HTML Form(폼)을 통해 입력되는 데이터를 테이블 형태로 보여주고, 데이터베이스에 저장하고, 수정하고, 삭제할 수 있도록 다음의 조건을 만족 시키는 PHP 문서들을 작성하시오.  
  
  
# 조건/요구사항
## [완료] `[HTML, CSS]` 입력 폼은 다음 중에 최소 4개를 사용해야 함.
(text와 password는 2개로 인정하지 않고, 동일 form 객체로 인정함)
- [X] text/password box (로그인 등에 사용)
- [ ] textarea
- [X] checkbox (마이페이지에서 사용)
- [X] radio button (검색창에서 사용)
- [X] dropdown list = select/option tag (관리자용 책 정보 페이지에서 사용)
- [ ] 그 외 HTML5에서 사용되는 calendar 등 다른 입력 폼도 허용됨
 
## [완료] `[PHP]`
- [X] 회원가입 및 Login 페이지는 필수 (로그인 후, 회원 전용 페이지와 비회원 페이지 구별)
- [X] 나머지는 주제와 관련된 페이지로 구성하되, 1~3번의 조건/요구사항을 만족하는 페이지로 구성한다.   
예) 도서 대여 사이트인 경우, 비회원은 대여 불가하고, 전체 도서 목록만 열람 가능하며, 회원은 대여 가능  
    도서를 등록/수정/삭제하는 페이지가 필요하며, 회원이 도서 대여시 전체 도서 목록을 열람하는 페이지에서
    "대여가능"->"대여불가"로 상태변경해서 보여주어야 함
 
## [완료] `[DB]`
- [X] 반드시 Join과 Subquery를 각각 1번 이상 사용하여 query를 작성하고, 이를 결과로 보여주어야 함. (Join - 상세페이지, Subquery - 새로들어온 책)
- [X] 수정/삭제 기능을 위해서 update와 delete 사용
- [X] 테이블의 개수는 최소 4개 이상이어야 하며,
- [X] 각 테이블 당 record의 개수는 최소 10개 이상
 

## `[제출]` 제출해야 할 파일은 전체 소스코드와 데이터베이스 백업 파일을 모두 압축하여 학번.zip파일로 제출

백업 받을 때, 다음과 같이 (학번.sql 파일) 형태로...  // DB이름: test, Table이름: info 인 경우  

    C:\Users\Administrator>mysqldump -u root -p test info > 20221001.sql  

백업 후 반드시 백업이 잘 되었는지 sql 파일을 메모장에서 확인할 것.  
(반드시) 아래와 같이 테이블 생성 쿼리 및 저장 쿼리가 있어야 함.  

    CREATE TABLE `info` (
    `id` varchar(15) NOT NULL,
    `pwd` varchar(15) NOT NULL,
    `name` varchar(20) NOT NULL,
    `age` int DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
    /*!40101 SET character_set_client = @saved_cs_client */;
    
    --
    -- Dumping data for table `info`
    --
    
    LOCK TABLES `info` WRITE;
    /*!40000 ALTER TABLE `info` DISABLE KEYS */;
    INSERT INTO `info` VALUES ('admin','admin','administrator1',66);