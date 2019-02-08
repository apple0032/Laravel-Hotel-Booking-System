{
    #"status": "success",
    "swagger": "2.0",
    "info": {
        "description": "<h3><b>API Documentation</b></h3></br>",
        "version": "1.0.0",
        "title": "API Documentation",
        "termsOfService": "http://swagger.io/terms/",
        "contact": {
            "email": "kenip0813@gmail.com"
        },
        "license": {
            "name": "KenIp",
            "url": "http://google.com"
        }
    },
    #"host": "ken.com/restful-api",
    "basePath": "/index.php",
    "tags": [
        {
            "name": "admin-user",
            "description": "Admin manages user's actions"
        },
        {
            "name": "account",
            "description": "User manages their account information"
        },
        {
            "name": "hotel",
            "description": "Hotel actions made by user"
        },
        {
            "name": "booking",
            "description": "Booking action made by user"
        },
        {
            "name": "search",
            "description": "Searching API"
        },
        {
            "name": "admin-hotel",
            "description": "Admin manages hotel information"
        },
        {
            "name": "admin-booking-payment",
            "description": "Admin manages client Booking & Payment"
        },
        {
            "name": "admin-category",
            "description": "Admin manages hotel categories"
        },
        {
            "name": "admin-tags",
            "description": "Admin manages hotel tags"
        },
        {
            "name": "admin-paymethod",
            "description": "Admin manages payment methods"
        },
        {
            "name": "admin-statistic",
            "description": "Admin get statistic"
        },
        {
            "name": "admin-config",
            "description": "Admin manages config"
        },
    ],
    "schemes": [
        "https",
        "http"
    ],
    "paths": {
        "/admin/user": {
            "get": {
                "tags": [
                    "admin-user"
                ],
                "summary": "Get all user data",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "is_deleted",
                        "type": "boolean",
                        "description": "",
                        "required": false,
                        "default" : '0',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "created_at",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    }
                }
            },
            "post": {
                "tags": [
                    "admin-user"
                ],
                "summary": "Create user",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "email",
                        "type": "string",
                        "description": "User email for login",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "password",
                        "type": "string",
                        "description": "User password encrypted by bcrypt",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "User name",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "phone",
                        "type": "string",
                        "description": "User phone",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "gender",
                        "type": "string",
                        "description": "User gender",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "role",
                        "type": "string",
                        "description": "User role",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    }
                }
            },
        },
        "/admin/user/{user_id}": {
            "get": {
                "tags": [
                    "admin-user"
                ],
                "summary": "Get user by id",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/xml",
                    "application/json"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "user_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    }
                }
            },
            "put": {
                "tags": [
                    "admin-user"
                ],
                "summary": "Update user details by id",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/xml",
                    "application/json"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "user_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "email",
                        "type": "string",
                        "description": "User email for login",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "password",
                        "type": "string",
                        "description": "User password encrypted by bcrypt",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "User name",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "phone",
                        "type": "string",
                        "description": "User phone",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "gender",
                        "type": "string",
                        "description": "User gender",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "role",
                        "type": "string",
                        "description": "User role",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    }
                }
            },
            "delete": {
                "tags": [
                    "admin-user"
                ],
                "summary": "Delete a user",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/xml",
                    "application/json"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "user_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "is_deleted",
                        "type": "boolean",
                        "description": "Set a user soft delete or real delete",
                        "required": false,
                        "default" : '0',
                        "enum":["1","0"]
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    }
                }
            }
        },
        
        "/account/checklogin": {
            "get": {
                "tags": [
                    "account"
                ],
                "summary": "Get all user data",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "email",
                        "type": "string",
                        "description": "User email for login",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "password",
                        "type": "string",
                        "description": "User password encrypted by bcrypt",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                        "description": '"status": "success", "login" : "success", "user_id" : "{user_id}"'
                    },
                }
            },
        },
        
        "/account/apikey/{user_id}": {
            "get": {
                "tags": [
                    "account"
                ],
                "summary": "Generate and return unique API Key",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication, Request admin level api key.",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "user_id",
                        "type": "integer",
                        "description": "user_id for generated user_id",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                        "description": '"status":"success", "user_id":"{user_id}", "Api-key":"api-123321", '
                    },
                }
            },
        },
        
        "/account/{user_id}": {
            "get": {
                "tags": [
                    "account"
                ],
                "summary": "Get user account information",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "user_id",
                        "type": "integer",
                        "description": "user_id to be taken",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                        "description": '"status": "success", "user_id":"{user_id}"'
                    },
                }
            },
            "put": {
                "tags": [
                    "account"
                ],
                "summary": "Get user account information",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "user_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "User name",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "password",
                        "type": "string",
                        "description": "User password encrypted by bcrypt",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "phone",
                        "type": "string",
                        "description": "User phone",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "gender",
                        "type": "string",
                        "description": "User gender",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                        "description": '"status": "success", "user_id":"{user_id}"'
                    },
                }
            },
        },
        
        "/hotel/list": {
            "get": {
                "tags": [
                    "hotel"
                ],
                "summary": "Get all hotels information",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                        "description": '"status": "success"'
                    },
                }
            },
        },
        
        "/hotel/{hotel_id}": {
            "get": {
                "tags": [
                    "hotel"
                ],
                "summary": "Get a specific hotel information",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "hotel_id to be taken",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                        "description": '"status": "success", "hotel_id":"{hotel_id}"'
                    },
                }
            },
        },
       
        "/hotel/comment/{hotel_id}": {
            "get": {
                "tags": [
                    "hotel"
                ],
                "summary": "Get a hotel comment",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "hotel_id to be taken",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                        "description": '"status": "success", "hotel_id":"{hotel_id}"'
                    },
                }
            },
            "post": {
                "tags": [
                    "hotel"
                ],
                "summary": "Post a hotel comment",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "hotel_id to be taken",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "user_id",
                        "type": "integer",
                        "description": "user_id to be taken",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "comment",
                        "type": "string",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "star",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                        "description": '"status": "success", "hotel_id":"{hotel_id}"'
                    },
                }
            },
        },
        
        "/hotel/room/{hotel_id}": {
            "get": {
                "tags": [
                    "hotel"
                ],
                "summary": "Get hotel room by id",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "hotel_id to be taken",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                        "description": '"status": "success", "hotel_id":"{hotel_id}"'
                    },
                }
            },
        },

        "/hotel/room/status": {
            "get": {
                "tags": [
                    "booking"
                ],
                "summary": "Get room booking status by date",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "Request hotel_id or room_id at least one",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "room_id",
                        "type": "integer",
                        "description": "Search all room if not provided",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "from_date",
                        "type": "string",
                        "description": "Give a date to search booking status",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "to_date",
                        "type": "string",
                        "description": "Give a date to search booking status",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "hotel_id": "{hotel_id}",
                            "room_id": "{room_id}",
                            "from_date": "{from_date}", #2018-01-28 as example
                            "to_date": "{to_date}",  #2018-01-29 as example
                            "hotel_room": [
                              {
                                "id": "1",
                                "hotel_id": "40",
                                "dayslot": [
                                  {
                                  "date": "2019-01-28",
                                  "book_status": "40%",
                                  "availability" : "1"
                                  },
                                  {
                                  "date": "2019-01-29",
                                  "book_status": "100%",
                                  "availability" : "0"
                                  },
                                ]
                              },
                              
                              {
                                "id": "5",
                                "hotel_id": "320",
                                "dayslot": [
                                  {
                                  "date": "2019-01-28",
                                  "book_status": "0%",
                                  "availability" : "1"
                                  },
                                  {
                                  "date": "2019-01-29",
                                  "book_status": "45%",
                                  "availability" : "0"
                                  },
                                ]
                              },
                            ]
                        }
                      }
                    }
                }
            },
        },
        
        
        "/hotel/room/validation": {
            "get": {
                "tags": [
                    "booking"
                ],
                "summary": "Validate room booking status",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "room_id",
                        "type": "integer",
                        "description": "Search all room if not provided",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "from_date",
                        "type": "string",
                        "description": "Give a date to search booking status",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "to_date",
                        "type": "string",
                        "description": "Give a date to search booking status",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "room_id": "{room_id}",
                            "from_date": "{from_date}", #2018-01-28 as example
                            "to_date": "{to_date}",  #2018-01-29 as example
                            "hotel_room": [
                              {
                                "id": "1", #room_id
                                "hotel_id": "40", #hotel_id
                                "dayslot": [
                                  {
                                  "date": "2019-01-28",
                                  "availability" : "1"
                                  },
                                  {
                                  "date": "2019-01-29",
                                  "availability" : "0"
                                  },
                                ]
                              },
                            ]
                        }
                      }
                    }
                }
            },
        },
      
        "/hotel/booking/{user_id}": {
            "get": {
                "tags": [
                    "booking"
                ],
                "summary": "Get all booking by a user",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "user_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "in_date",
                        "type": "string",
                        "description": "Give a date to search booking status",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "out_date",
                        "type": "string",
                        "description": "Give a date to search booking status",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "status",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "user_id": "{user_id}",
                            "booking": [],
                        }
                      }
                    }
                }
            },
            "post": {
                "tags": [
                    "booking"
                ],
                "summary": "Create booking & payment",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "user_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "in_date",
                        "type": "string",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "out_date",
                        "type": "string",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "room_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "people",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "payment_method_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "card_number",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "expired_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "security_number",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "status",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "user_id": "{user_id}",
                            "bookng": {},
                            "payment" : {}
                        }
                      }
                    }
                }
            },
        },

        "/hotel/payment/{user_id}": {
            "get": {
                "tags": [
                    "booking"
                ],
                "summary": "Get all payment by a user",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "user_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "in_date",
                        "type": "string",
                        "description": "Give a date to search booking status",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "out_date",
                        "type": "string",
                        "description": "Give a date to search booking status",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "payment_method_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "status",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "user_id": "{user_id}",
                            "payment": {},
                        }
                      }
                    }
                }
            },
        },
        
        
        
        "/hotel/booking/guest/{booking_id}": {
            "post": {
                "tags": [
                    "booking"
                ],
                "summary": "Create a guest for a booking",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "booking_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "phone",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "gender",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "email",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "user_id": "{user_id}",
                            "guests": [
                                {
                                  "id" : "1",
                                  "name" : "peter",
                                  "phone" : "98765432",
                                  "gender" : "M",
                                  "email" : "example@gmail.com"
                                },
                                {
                                  "id" : "2",
                                  "name" : "ken",
                                  "phone" : "66998745",
                                  "gender" : "F",
                                  "email" : "example@gmail.com"
                                },
                              ],
                        }
                      }
                    }
                }
            },
        },

        "/hotel/search/normal": {
            "get": {
                "tags": [
                    "search"
                ],
                "summary": "Normal searching",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "category_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "star",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "tags",
                        "type": "integer",
                        "description": "This field should be a comma string",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "room_type_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                        "enum":["1","2","3"]
                    },
                    {
                        "in": "formData",
                        "name": "people",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "price_low",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "price_up",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "from_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "to_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },
        },        


        "/hotel/search/advanced": {
            "get": {
                "tags": [
                    "search"
                ],
                "summary": "Advanced searching",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "category_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "star",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "tags",
                        "type": "integer",
                        "description": "This field should be a comma string",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "room_type_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                        "enum":["1","2","3"]
                    },
                    {
                        "in": "formData",
                        "name": "people",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "price_low",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "price_up",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "from_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "to_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "orderby",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "groupby",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "algorithm_type",
                        "type": "string",
                        "description": "this field is used for algorithm searching (further development)",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "algorithm_count",
                        "type": "string",
                        "description": "",
                        "required": false,
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "format",
                        "type": "string",
                        "description": "",
                        "required": false,
                        "default" : "JSON",
                        "enum":["JSON","XML","HTML"]
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },
        },   
        
        "/admin/hotel": {
            "post": {
                "tags": [
                    "admin-hotel"
                ],
                "summary": "Create hotel",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "phone",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "category_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "star",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "tags",
                        "type": "integer",
                        "description": "This field should be a comma string",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "featured-img",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "handling_price",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "body",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "coordi_x",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "coordi_y",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "new",
                        "type": "string",
                        "description": "Check the hotel from API or from custom create",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "soft_delete",
                        "type": "string",
                        "description": "",
                        "required": false,                        
                        "default" : '0',
                        "enum":["1","0"]
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "hotel" :                     
                            {
                                "id": "40",
                                "name": "Peninsula",
                                "star": "4",
                                "category_id": "5",
                            },
                        }
                      }
                    }
                }
            },
        },           


        "/admin/hotel/{hotel_id}": {
            "put": {
                "tags": [
                    "admin-hotel"
                ],
                "summary": "Update hotel info",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "phone",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "category_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "star",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "tags",
                        "type": "integer",
                        "description": "This field should be a comma string",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "featured-img",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "handling_price",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "body",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "coordi_x",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "coordi_y",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "new",
                        "type": "string",
                        "description": "Check the hotel from API or from custom create",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "soft_delete",
                        "type": "string",
                        "description": "",
                        "required": false,                        
                        "default" : '0',
                        "enum":["1","0"]
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "hotel" :                     
                            {
                                "id": "40",
                                "name": "Peninsula",
                                "star": "4",
                                "category_id": "5",
                            },
                        }
                      }
                    }
                }
            },
            
            "delete": {
                "tags": [
                    "admin-hotel"
                ],
                "summary": "Hard Delete Hotel",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "hotel" :                     
                            {
                                "id": "40",
                                "name": "Peninsula",
                            },
                        }
                      }
                    }
                }
            },
        }, 

        "/admin/hotel/fac/{hotel_id}": {
            "post": {
                "tags": [
                    "admin-hotel"
                ],
                "summary": "Create Hotel Facilities",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "free_cancel",
                        "type": "integer",
                        "description": "",
                        "required": true,                        
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "all_day_services",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "wifi",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "restaurant",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "washing_service",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "car_park",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "meeting_room",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "bar",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "gym_room",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "swim_pool",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "hotel" :                     
                            {
                                "id": "40",
                            },
                        }
                      }
                    }
                }
            },
            "put": {
                "tags": [
                    "admin-hotel"
                ],
                "summary": "Update Hotel Facilities",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "free_cancel",
                        "type": "integer",
                        "description": "",
                        "required": false,                        
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "all_day_services",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "wifi",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "restaurant",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "washing_service",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "car_park",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "meeting_room",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "bar",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "gym_room",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "swim_pool",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                        "default" : '1',
                        "enum":["1","0"]
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "hotel" :                     
                            {
                                "id": "40",
                            },
                        }
                      }
                    }
                }
            },
        },         
        

       "/admin/hotel/room": {
            "post": {
                "tags": [
                    "admin-hotel"
                ],
                "summary": "Create Hotel Room",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "room_type_id",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                    },
                    {
                        "in": "formData",
                        "name": "ppl_limit",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                    },
                    {
                        "in": "formData",
                        "name": "price",
                        "type": "integer",
                        "description": "",
                        "required": true,                      
                    },
                    {
                        "in": "formData",
                        "name": "qty",
                        "type": "integer",
                        "description": "Number of room supply",
                        "required": true,                      
                    },
                    {
                        "in": "formData",
                        "name": "availability",
                        "type": "integer",
                        "description": "",
                        "required": true,
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "promo",
                        "type": "integer",
                        "description": "",
                        "required": true,
                        "default" : '1',
                        "enum":["1","0"]
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "hotel" :                     
                            {
                                "id": "40",
                            },
                            "room" :                     
                            {
                                "id": "40",
                                "price" : "200",
                                "qty" : "20"
                            },
                        }
                      }
                    }
                }
            },
        },        
        
       "/admin/hotel/room/{room_id}": {
            "put": {
                "tags": [
                    "admin-hotel"
                ],
                "summary": "Update Hotel Room",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "room_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "room_type_id",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                    },
                    {
                        "in": "formData",
                        "name": "ppl_limit",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                    },
                    {
                        "in": "formData",
                        "name": "price",
                        "type": "integer",
                        "description": "",
                        "required": false,                      
                    },
                    {
                        "in": "formData",
                        "name": "qty",
                        "type": "integer",
                        "description": "Number of room supply",
                        "required": false,                      
                    },
                    {
                        "in": "formData",
                        "name": "availability",
                        "type": "integer",
                        "description": "",
                        "required": false,
                        "default" : '1',
                        "enum":["1","0"]
                    },
                    {
                        "in": "formData",
                        "name": "promo",
                        "type": "integer",
                        "description": "",
                        "required": false,
                        "default" : '1',
                        "enum":["1","0"]
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "hotel" :                     
                            {
                                "id": "40",
                            },
                            "room" :                     
                            {
                                "id": "40",
                                "price" : "200",
                                "qty" : "20"
                            },
                        }
                      }
                    }
                }
            },
            "delete": {
                "tags": [
                    "admin-hotel"
                ],
                "summary": "Delete Hotel Room",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "room_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "hotel" :                     
                            {
                                "id": "40",
                            },
                            "room" :                     
                            {
                                "id": "40",
                                "price" : "200",
                                "qty" : "20"
                            },
                        }
                      }
                    }
                }
            },
        },             
  
        "/admin/hotel/booking/{booking_id}": {
            "put": {
                "tags": [
                    "admin-booking-payment"
                ],
                "summary": "Update Client Booking",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "booking_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "user_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "in_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "out_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "book_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "hotel_room_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "people",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "total_price",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "payment_method_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "approved",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "status",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },
            "delete": {
                "tags": [
                    "admin-booking-payment"
                ],
                "summary": "Delete Booking + Payment + Guest",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "booking_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },
        },      
        
        
        "/admin/hotel/payment/{payment_id}": {
            "put": {
                "tags": [
                    "admin-booking-payment"
                ],
                "summary": "Update Client Payment",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "payment_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "user_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "single_price",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "handling_price",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "total_price",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "payment_method_id",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "card_number",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "expired_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "security_number",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "status",
                        "type": "integer",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },
        },
       
        "/admin/hotel/guest/{booking_id}": {
            "put": {
                "tags": [
                    "admin-booking-payment"
                ],
                "summary": "Update Client Booking's guest",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "booking_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "phone",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "gender",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "email",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },

            "delete": {
                "tags": [
                    "admin-booking-payment"
                ],
                "summary": "Delete guest from a booking",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "booking_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "phone",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "gender",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "email",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },            
        },
        
      "/admin/category": {
            "get": {
                "tags": [
                    "admin-category"
                ],
                "summary": "List all categories",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "Search with LIKE %{string}%",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },

            "post": {
                "tags": [
                    "admin-category"
                ],
                "summary": "Create a new category",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "id" : "5",
                            "name" : "category"
                        }
                      }
                    }
                }
            },
        },  
        
      "/admin/category/{category_id}": {
            "put": {
                "tags": [
                    "admin-category"
                ],
                "summary": "Update a category",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "category_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "id" : "5",
                            "name" : "category"
                        }
                      }
                    }
                }
            },
            
            "delete": {
                "tags": [
                    "admin-category"
                ],
                "summary": "Delete a category",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "category_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "id" : "5",
                            "name" : "category"
                        }
                      }
                    }
                }
            },            
      },          
        

      "/admin/tags": {
            "get": {
                "tags": [
                    "admin-tags"
                ],
                "summary": "List all tags",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "Search with LIKE %{string}%",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },

            "post": {
                "tags": [
                    "admin-tags"
                ],
                "summary": "Create a new tag",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "id" : "15",
                            "name" : "marvelous"
                        }
                      }
                    }
                }
            },
        },         

      "/admin/tags/{tag_id}": {
            "put": {
                "tags": [
                    "admin-tags"
                ],
                "summary": "Update a tag",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "tag_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "name",
                        "type": "string",
                        "description": "",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "id" : "5",
                            "name" : "tag"
                        }
                      }
                    }
                }
            },
            
            "delete": {
                "tags": [
                    "admin-tags"
                ],
                "summary": "Delete a tag",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "tag_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "id" : "5",
                            "name" : "tag"
                        }
                      }
                    }
                }
            },            
      },
      

      "/admin/tags/hotel/{hotel_id}": {
            "post": {
                "tags": [
                    "admin-tags"
                ],
                "summary": "Add tags into hotel",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "tag_id",
                        "type": "integer",
                        "description": "This field support comma string",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "hotel_id" : "5",
                            "tag_id" : "10"
                        }
                      }
                    }
                }
            },
            
            "delete": {
                "tags": [
                    "admin-tags"
                ],
                "summary": "Remove tags from hotel",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "hotel_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "tag_id",
                        "type": "integer",
                        "description": "This field support comma string",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "hotel_id" : "5",
                            "tag_id" : "10"
                        }
                      }
                    }
                }
            },            
      },
      
      
      "/admin/paymentMethod": {
            "get": {
                "tags": [
                    "admin-paymethod"
                ],
                "summary": "List all payment method",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "type",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },

            "post": {
                "tags": [
                    "admin-paymethod"
                ],
                "summary": "Create a new payment method",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "type",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "id" : "15",
                            "type" : "visa"
                        }
                      }
                    }
                }
            },
        },         

      "/admin/paymentMethod/{method_id}": {
            "put": {
                "tags": [
                    "admin-paymethod"
                ],
                "summary": "Update a payment method",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "method_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "type",
                        "type": "string",
                        "description": "",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "id" : "5",
                            "type" : "visa"
                        }
                      }
                    }
                }
            },
            
            "delete": {
                "tags": [
                    "admin-paymethod"
                ],
                "summary": "Delete a payment method",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "path",
                        "name": "method_id",
                        "type": "integer",
                        "description": "",
                        "required": true,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                            "id" : "5",
                            "type" : "visa"
                        }
                      }
                    }
                }
            },            
      },
      
      
      "/admin/stat/bookingStatus": {
            "get": {
                "tags": [
                    "admin-statistic"
                ],
                "summary": "Get all hotel all booking status by a specific period",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "from_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "to_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "hotel_id",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },
        },      
      
        "/admin/stat/rank": {
            "get": {
                "tags": [
                    "admin-statistic"
                ],
                "summary": "Get the rank list of all hotel",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "star",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "category_id",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },
        },    

        "/admin/stat/invoice": {
            "get": {
                "tags": [
                    "admin-statistic"
                ],
                "summary": "Get the total invoice/income by a specific period",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "from_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "to_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "hotel_id",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },
        },  
      
        "/admin/stat/searching": {
            "get": {
                "tags": [
                    "admin-statistic"
                ],
                "summary": "Return statistic data which calculated by user input",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "from_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                    {
                        "in": "formData",
                        "name": "to_date",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },
        },  

        "/admin/config/pageno": {
            "put": {
                "tags": [
                    "admin-config"
                ],
                "summary": "Config the number of hotels displayed in one page",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "page_no",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },
        },          
        
        "/admin/config/about": {
            "put": {
                "tags": [
                    "admin-config"
                ],
                "summary": "Config about page content",
                "consumes": [
                    "application/x-www-form-urlencoded"
                ],
                "produces": [
                    "application/json",
                    "application/xml"
                ],
                "parameters": [
                    {
                        "in": "formData",
                        "name": "api-key",
                        "type": "string",
                        "description": "For authentication",
                        "required": true,
                    },
                    {
                        "in": "formData",
                        "name": "about",
                        "type": "string",
                        "description": "",
                        "required": false,
                    },
                ],
                "responses": {
                    "500": {
                        "description": "\"status\": \"error\","
                    },
                    "200": {
                      "description": "Success output",
                      "examples": {
                        "application/json": {
                            "status": "success",
                        }
                      }
                    }
                }
            },
        },
        
        
        
    }
}