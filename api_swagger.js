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
            "description": "Admin manages the user's actions, which are located in the AdminController"
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
                "summary": "Delete",
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
                        "description": "user_id for generated user_id",
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
                            "payment": [],
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
                        "description": "user_id for generated user_id",
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
                            "payment": [],
                        }
                      }
                    }
                }
            },
        },
        
        

    }
}