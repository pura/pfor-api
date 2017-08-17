pfor-api
===========

Simple API that will allow two users to chat between them.


**Installation**

* Run docker-compose up (or docker-compose up --build -d)

**Routes**

**New Contact Request:** 
* http://localhost:8087/app_dev.php/api/v1/contact/request/{senderId}/{receiverId}

**Contact Request Receive:**
* http://localhost:8087/app_dev.php/api/v1/contact/receive/{senderId}

**Message Send:**
* http://localhost:8087/app_dev.php/api/v1/message/send/{contactRef}

**Message read**
* http://localhost:8087/app_dev.php/api/v1/message/send/{contactRef}


Future Improvement
===================
* Use of RestApiBundle
* Error Handling
* Response Object creation with payload
* And others .. 
