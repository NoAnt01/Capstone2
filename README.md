# 🚀 AIPICK (아이픽) - AI 추천 및 교육 플랫폼

## 📖 프로젝트 소개
AIPICK(아이픽)은 사용자에게 꼭 맞는 AI와 학습 경로를 탐색하고 추천해 주는 종합 AI 플랫폼입니다. 최신 AI 도구 추천부터 국비지원 부트캠프, 추천 강의 및 도서 정보, 그리고 실시간 AI 소식까지 한곳에서 확인할 수 있습니다.

## 👥 팀원 및 역할 분담
* **김주호(조장)**: 웹 서비스 개발 전반 총괄, 파일 구조 설계 및 도메인 관리, 메인 페이지 및 기타 기능(광고/후원 등) 구현
* **노성겸**: AI 교육(강의) 페이지, 마이페이지, 문의 기능, 회원가입/로그인 기능 구현 및 시스템 아키텍처(Flowchart) 설계
* **박진우**: AI 교육(국비지원캠프) 페이지, 관리자 페이지 구현 및 시스템 아키텍처(ERD) 설계
* **장준하**: 메인 페이지, AI 추천, AI 소식 페이지 구현
* **이규민**: AI 교육(도서) 페이지, 상세 페이지, 사용자 후기 및 커뮤니티 구현

---

## 🏗 시스템 아키텍처

### ERD
![ER-D](https://private-user-images.githubusercontent.com/66471503/698866802-9dec6a87-4aaa-40f9-81fa-3551ee96d08f.png?jwt=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3OTQxMzAyNjUsIm5iZiI6MTc5NDEyOTk2NSwicGF0aCI6Ii82NjQ3MTUwMy82OTg4NjY4MDItOWRlYzZhODctNGFhYS00MGY5LTgxZmEtMzU1MWVlOTZkMDhmLnBuZz9YLUFtei1BbGdvcml0aG09QVdTNC1ITUFDLVNIQTI1NiZYLUFtei1DcmVkZW50aWFsPUFLSUFWQ09EWUxTQTUzUFFLNFpBJTJGMjAyNjExMDglMkZ1cy1lYXN0LTElMkZzMyUyRmF3czRfcmVxdWVzdCZYLUFtei1EYXRlPTIwMjYxMTA4VDA5MjYwNVomWC1BbXotRXhwaXJlcz0zMDAmWC1BbXotU2lnbmF0dXJlPTQwMGQ4OGEwMTg0YTk4N2U4NDQ0ZmJjMGQ3OThmMmRkYWE5OGZkOWE1OTI3N2E5N2QxOGY2MWFlMjU5NzEzMjAmWC1BbXotU2lnbmVkSGVhZGVycz1ob3N0JnJlc3BvbnNlLWNvbnRlbnQtdHlwZT1pbWFnZSUyRnBuZyJ9.DA3UR87XniFPSffR9j6KDLLiiF3cP2Roznfw3x2dOKo)

### Flowchart
![Flowchart](https://private-user-images.githubusercontent.com/66471503/698866974-217a4da3-07ab-4d69-88ab-5b3a9488eccb.png?jwt=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3OTQxMzAyMTUsIm5iZiI6MTc5NDEyOTkxNSwicGF0aCI6Ii82NjQ3MTUwMy82OTg4NjY5NzQtMjE3YTRkYTMtMDdhYi00ZDY5LTg4YWItNWIzYTk0ODhlY2NiLnBuZz9YLUFtei1BbGdvcml0aG09QVdTNC1ITUFDLVNIQTI1NiZYLUFtei1DcmVkZW50aWFsPUFLSUFWQ09EWUxTQTUzUFFLNFpBJTJGMjAyNjExMDglMkZ1cy1lYXN0LTElMkZzMyUyRmF3czRfcmVxdWVzdCZYLUFtei1EYXRlPTIwMjYxMTA4VDA5MjUxNVomWC1BbXotRXhwaXJlcz0zMDAmWC1BbXotU2lnbmF0dXJlPWIxZjg2OTkyZTM3YzljZTU3ZWRlNDBiNDg0YTVhZjY0ODBkZTkxYjFiNWVmYjI2NDIyZDdiYzBjOGRiMzdjYzMmWC1BbXotU2lnbmVkSGVhZGVycz1ob3N0JnJlc3BvbnNlLWNvbnRlbnQtdHlwZT1pbWFnZSUyRnBuZyJ9.jIjiphYdgq4uwyRnxj9cIDZ-RBx7TabM93A3cZN2_9I)

---

## 💻 담당 기능 상세

### 1. 🔐 회원가입, 로그인 및 마이페이지
* **회원가입/로그인**: 필수 및 선택 약관 동의(이메일 수신 동의 등) 기능을 구현하였으며, 입력 항목 누락 및 비밀번호 조건(영문/숫자/특수문자 조합 10~16자) 불충족 시 토스트 알림을 통해 유효성 검사를 수행합니다.
* **마이페이지**: 닉네임, 이메일, 비밀번호 변경 기능과 이메일 수신 동의 체크박스(AJAX 방식)를 구현하였으며, 회원 탈퇴 시 DB에서 정보가 삭제되도록 설계했습니다.
* **문의 기능**: 사용자가 '나의 문의 내역'을 한눈에 조회할 수 있도록 하였으며, 관리자 답변 완료 시 파란색 라벨로 시각적 인지도를 높였습니다. 또한, 개인정보 보호를 위해 직접 문의 내역을 삭제할 수 있는 기능을 구현했습니다.
