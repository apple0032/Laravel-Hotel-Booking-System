{
    "paths": {
    "/admin/config/about": {
        "put": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "about",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Config about page content",
                "tags": [
                "admin-config"
            ]
        }
    },
    "/admin/config/pageno": {
        "put": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "page_no",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Config the number of hotels displayed in one page",
                "tags": [
                "admin-config"
            ]
        }
    },
    "/admin/stat/searching": {
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "from_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "to_date",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Return statistic data which calculated by user input",
                "tags": [
                "admin-statistic"
            ]
        }
    },
    "/admin/stat/invoice": {
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "from_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "to_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "hotel_id",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get the total invoice/income by a specific period",
                "tags": [
                "admin-statistic"
            ]
        }
    },
    "/admin/stat/rank": {
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "star",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "category_id",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get the rank list of all hotel",
                "tags": [
                "admin-statistic"
            ]
        }
    },
    "/admin/stat/bookingStatus": {
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "from_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "to_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "hotel_id",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get all hotel all booking status by a specific period",
                "tags": [
                "admin-statistic"
            ]
        }
    },
    "/admin/paymentMethod/{method_id}": {
        "delete": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "type": "visa",
                                "id": "5",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "method_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Delete a payment method",
                "tags": [
                "admin-paymethod"
            ]
        },
        "put": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "type": "visa",
                                "id": "5",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "method_id",
                    "in": "path"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "string",
                    "name": "type",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Update a payment method",
                "tags": [
                "admin-paymethod"
            ]
        }
    },
    "/admin/paymentMethod": {
        "post": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "type": "visa",
                                "id": "15",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "type",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Create a new payment method",
                "tags": [
                "admin-paymethod"
            ]
        },
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "type",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "List all payment method",
                "tags": [
                "admin-paymethod"
            ]
        }
    },
    "/admin/tags/hotel/{hotel_id}": {
        "delete": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "tag_id": "10",
                                "hotel_id": "5",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "path"
                },
                {
                    "required": true,
                    "description": "This field support comma string",
                    "type": "integer",
                    "name": "tag_id",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Remove tags from hotel",
                "tags": [
                "admin-tags"
            ]
        },
        "post": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "tag_id": "10",
                                "hotel_id": "5",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "path"
                },
                {
                    "required": true,
                    "description": "This field support comma string",
                    "type": "integer",
                    "name": "tag_id",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Add tags into hotel",
                "tags": [
                "admin-tags"
            ]
        }
    },
    "/admin/tags/{tag_id}": {
        "delete": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "name": "tag",
                                "id": "5",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "tag_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Delete a tag",
                "tags": [
                "admin-tags"
            ]
        },
        "put": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "name": "tag",
                                "id": "5",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "tag_id",
                    "in": "path"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Update a tag",
                "tags": [
                "admin-tags"
            ]
        }
    },
    "/admin/tags": {
        "post": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "name": "marvelous",
                                "id": "15",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Create a new tag",
                "tags": [
                "admin-tags"
            ]
        },
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "Search with LIKE %{string}%",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "List all tags",
                "tags": [
                "admin-tags"
            ]
        }
    },
    "/admin/category/{category_id}": {
        "delete": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "name": "category",
                                "id": "5",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "category_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Delete a category",
                "tags": [
                "admin-category"
            ]
        },
        "put": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "name": "category",
                                "id": "5",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "category_id",
                    "in": "path"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Update a category",
                "tags": [
                "admin-category"
            ]
        }
    },
    "/admin/category": {
        "post": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "name": "category",
                                "id": "5",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Create a new category",
                "tags": [
                "admin-category"
            ]
        },
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "Search with LIKE %{string}%",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "List all categories",
                "tags": [
                "admin-category"
            ]
        }
    },
    "/admin/hotel/guest/{booking_id}": {
        "delete": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "booking_id",
                    "in": "path"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "phone",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "gender",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "email",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Delete guest from a booking",
                "tags": [
                "admin-booking-payment"
            ]
        },
        "put": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "booking_id",
                    "in": "path"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "phone",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "gender",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "email",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Update Client Booking's guest",
                "tags": [
                "admin-booking-payment"
            ]
        }
    },
    "/admin/hotel/payment/{payment_id}": {
        "put": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "payment_id",
                    "in": "path"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "user_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "single_price",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "handling_price",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "total_price",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "payment_method_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "card_number",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "expired_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "security_number",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "status",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Update Client Payment",
                "tags": [
                "admin-booking-payment"
            ]
        }
    },
    "/admin/hotel/booking/{booking_id}": {
        "delete": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "booking_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Delete Booking + Payment + Guest",
                "tags": [
                "admin-booking-payment"
            ]
        },
        "put": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "booking_id",
                    "in": "path"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "user_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "in_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "out_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "book_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_room_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "people",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "total_price",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "payment_method_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "approved",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "status",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Update Client Booking",
                "tags": [
                "admin-booking-payment"
            ]
        }
    },
    "/admin/hotel/room/{room_id}": {
        "delete": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "room": {
                                "qty": "20",
                                    "price": "200",
                                    "id": "40"
                            },
                            "hotel": {
                                "id": "40"
                            },
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "room_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Delete Hotel Room",
                "tags": [
                "admin-hotel"
            ]
        },
        "put": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "room": {
                                "qty": "20",
                                    "price": "200",
                                    "id": "40"
                            },
                            "hotel": {
                                "id": "40"
                            },
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "room_id",
                    "in": "path"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "room_type_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "ppl_limit",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "price",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "Number of room supply",
                    "type": "integer",
                    "name": "qty",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "availability",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "promo",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Update Hotel Room",
                "tags": [
                "admin-hotel"
            ]
        }
    },
    "/admin/hotel/room": {
        "post": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "room": {
                                "qty": "20",
                                    "price": "200",
                                    "id": "40"
                            },
                            "hotel": {
                                "id": "40"
                            },
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "path"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "room_type_id",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "ppl_limit",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "price",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "Number of room supply",
                    "type": "integer",
                    "name": "qty",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "availability",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "promo",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Create Hotel Room",
                "tags": [
                "admin-hotel"
            ]
        }
    },
    "/admin/hotel/fac/{hotel_id}": {
        "put": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "hotel": {
                                "id": "40"
                            },
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "path"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "free_cancel",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "all_day_services",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "wifi",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "restaurant",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "washing_service",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "car_park",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "meeting_room",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "bar",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "gym_room",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "swim_pool",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Update Hotel Facilities",
                "tags": [
                "admin-hotel"
            ]
        },
        "post": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "hotel": {
                                "id": "40"
                            },
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "path"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "free_cancel",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "all_day_services",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "wifi",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "restaurant",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "washing_service",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "car_park",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "meeting_room",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "bar",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "gym_room",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "1",
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "swim_pool",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Create Hotel Facilities",
                "tags": [
                "admin-hotel"
            ]
        }
    },
    "/admin/hotel/{hotel_id}": {
        "delete": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "hotel": {
                                "name": "Peninsula",
                                    "id": "40"
                            },
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Hard Delete Hotel",
                "tags": [
                "admin-hotel"
            ]
        },
        "put": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "hotel": {
                                "category_id": "5",
                                    "star": "4",
                                    "name": "Peninsula",
                                    "id": "40"
                            },
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "path"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "phone",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "category_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "star",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "This field should be a comma string",
                    "type": "integer",
                    "name": "tags",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "featured-img",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "handling_price",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "body",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "coordi_x",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "coordi_y",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "Check the hotel from API or from custom create",
                    "type": "string",
                    "name": "new",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "0",
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "soft_delete",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Update hotel info",
                "tags": [
                "admin-hotel"
            ]
        }
    },
    "/admin/hotel": {
        "post": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "hotel": {
                                "category_id": "5",
                                    "star": "4",
                                    "name": "Peninsula",
                                    "id": "40"
                            },
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "phone",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "category_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "star",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "This field should be a comma string",
                    "type": "integer",
                    "name": "tags",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "featured-img",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "handling_price",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "body",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "coordi_x",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "coordi_y",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "Check the hotel from API or from custom create",
                    "type": "string",
                    "name": "new",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "0",
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "soft_delete",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Create hotel",
                "tags": [
                "admin-hotel"
            ]
        }
    },
    "/hotel/search/advanced": {
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "category_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "star",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "This field should be a comma string",
                    "type": "integer",
                    "name": "tags",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "2",
                        "3"
                    ],
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "room_type_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "people",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "price_low",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "price_up",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "from_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "to_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "orderby",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "groupby",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "this field is used for algorithm searching (further development)",
                    "type": "string",
                    "name": "algorithm_type",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "algorithm_count",
                    "in": "formData"
                },
                {
                    "enum": [
                        "JSON",
                        "XML",
                        "HTML"
                    ],
                    "default": "JSON",
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "format",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Advanced searching",
                "tags": [
                "search"
            ]
        }
    },
    "/hotel/search/normal": {
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "category_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "star",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "This field should be a comma string",
                    "type": "integer",
                    "name": "tags",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "2",
                        "3"
                    ],
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "room_type_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "people",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "price_low",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "price_up",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "from_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "to_date",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Normal searching",
                "tags": [
                "search"
            ]
        }
    },
    "/hotel/booking/guest/{booking_id}": {
        "post": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "guests": [
                                {
                                    "email": "example@gmail.com",
                                    "gender": "M",
                                    "phone": "98765432",
                                    "name": "peter",
                                    "id": "1"
                                },
                                {
                                    "email": "example@gmail.com",
                                    "gender": "F",
                                    "phone": "66998745",
                                    "name": "ken",
                                    "id": "2"
                                }
                            ],
                                "user_id": "{user_id}",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "booking_id",
                    "in": "path"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "phone",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "gender",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "email",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Create a guest for a booking",
                "tags": [
                "booking"
            ]
        }
    },
    "/hotel/payment/{user_id}": {
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "user_id": "{user_id}",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "user_id",
                    "in": "path"
                },
                {
                    "required": true,
                    "description": "Give a date to search booking status",
                    "type": "string",
                    "name": "in_date",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "Give a date to search booking status",
                    "type": "string",
                    "name": "out_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "payment_method_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "status",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get all payment by a user",
                "tags": [
                "booking"
            ]
        }
    },
    "/hotel/booking/{user_id}": {
        "post": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "user_id": "{user_id}",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "user_id",
                    "in": "path"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "string",
                    "name": "in_date",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "string",
                    "name": "out_date",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "room_id",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "people",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "payment_method_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "card_number",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "expired_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "security_number",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "status",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Create booking & payment",
                "tags": [
                "booking"
            ]
        },
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "booking": [],
                                "user_id": "{user_id}",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "user_id",
                    "in": "path"
                },
                {
                    "required": true,
                    "description": "Give a date to search booking status",
                    "type": "string",
                    "name": "in_date",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "Give a date to search booking status",
                    "type": "string",
                    "name": "out_date",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "integer",
                    "name": "status",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get all booking by a user",
                "tags": [
                "booking"
            ]
        }
    },
    "/hotel/room/validation": {
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "hotel_room": [
                                {
                                    "dayslot": [
                                        {
                                            "availability": "1",
                                            "date": "2019-01-28"
                                        },
                                        {
                                            "availability": "0",
                                            "date": "2019-01-29"
                                        }
                                    ],
                                    "hotel_id": "40",
                                    "id": "1"
                                }
                            ],
                                "to_date": "{to_date}",
                                "from_date": "{from_date}",
                                "room_id": "{room_id}",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "Search all room if not provided",
                    "type": "integer",
                    "name": "room_id",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "Give a date to search booking status",
                    "type": "string",
                    "name": "from_date",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "Give a date to search booking status",
                    "type": "string",
                    "name": "to_date",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Validate room booking status",
                "tags": [
                "booking"
            ]
        }
    },
    "/hotel/room/status": {
        "get": {
            "responses": {
                "200": {
                    "examples": {
                        "application/json": {
                            "hotel_room": [
                                {
                                    "dayslot": [
                                        {
                                            "availability": "1",
                                            "book_status": "40%",
                                            "date": "2019-01-28"
                                        },
                                        {
                                            "availability": "0",
                                            "book_status": "100%",
                                            "date": "2019-01-29"
                                        }
                                    ],
                                    "hotel_id": "40",
                                    "id": "1"
                                },
                                {
                                    "dayslot": [
                                        {
                                            "availability": "1",
                                            "book_status": "0%",
                                            "date": "2019-01-28"
                                        },
                                        {
                                            "availability": "0",
                                            "book_status": "45%",
                                            "date": "2019-01-29"
                                        }
                                    ],
                                    "hotel_id": "320",
                                    "id": "5"
                                }
                            ],
                                "to_date": "{to_date}",
                                "from_date": "{from_date}",
                                "room_id": "{room_id}",
                                "hotel_id": "{hotel_id}",
                                "status": "success"
                        }
                    },
                    "description": "Success output"
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "Request hotel_id or room_id at least one",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "Search all room if not provided",
                    "type": "integer",
                    "name": "room_id",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "Give a date to search booking status",
                    "type": "string",
                    "name": "from_date",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "Give a date to search booking status",
                    "type": "string",
                    "name": "to_date",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get room booking status by date",
                "tags": [
                "booking"
            ]
        }
    },
    "/hotel/room/{hotel_id}": {
        "get": {
            "responses": {
                "200": {
                    "description": "\"status\": \"success\", \"hotel_id\":\"{hotel_id}\""
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "hotel_id to be taken",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get hotel room by id",
                "tags": [
                "hotel"
            ]
        }
    },
    "/hotel/comment/{hotel_id}": {
        "post": {
            "responses": {
                "200": {
                    "description": "\"status\": \"success\", \"hotel_id\":\"{hotel_id}\""
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "hotel_id to be taken",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "path"
                },
                {
                    "required": true,
                    "description": "user_id to be taken",
                    "type": "integer",
                    "name": "user_id",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "string",
                    "name": "comment",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "star",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Post a hotel comment",
                "tags": [
                "hotel"
            ]
        },
        "get": {
            "responses": {
                "200": {
                    "description": "\"status\": \"success\", \"hotel_id\":\"{hotel_id}\""
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "hotel_id to be taken",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get a hotel comment",
                "tags": [
                "hotel"
            ]
        }
    },
    "/hotel/{hotel_id}": {
        "get": {
            "responses": {
                "200": {
                    "description": "\"status\": \"success\", \"hotel_id\":\"{hotel_id}\""
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "hotel_id to be taken",
                    "type": "integer",
                    "name": "hotel_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get a specific hotel information",
                "tags": [
                "hotel"
            ]
        }
    },
    "/hotel/list": {
        "get": {
            "responses": {
                "200": {
                    "description": "\"status\": \"success\""
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get all hotels information",
                "tags": [
                "hotel"
            ]
        }
    },
    "/account/{user_id}": {
        "put": {
            "responses": {
                "200": {
                    "description": "\"status\": \"success\", \"user_id\":\"{user_id}\""
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "user_id",
                    "in": "path"
                },
                {
                    "required": false,
                    "description": "User name",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User password encrypted by bcrypt",
                    "type": "string",
                    "name": "password",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User phone",
                    "type": "string",
                    "name": "phone",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User gender",
                    "type": "string",
                    "name": "gender",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get user account information",
                "tags": [
                "account"
            ]
        },
        "get": {
            "responses": {
                "200": {
                    "description": "\"status\": \"success\", \"user_id\":\"{user_id}\""
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "user_id to be taken",
                    "type": "integer",
                    "name": "user_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get user account information",
                "tags": [
                "account"
            ]
        }
    },
    "/account/apikey/{user_id}": {
        "get": {
            "responses": {
                "200": {
                    "description": "\"status\":\"success\", \"user_id\":\"{user_id}\", \"Api-key\":\"api-123321\", "
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication, Request admin level api key.",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "user_id for generated user_id",
                    "type": "integer",
                    "name": "user_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Generate and return unique API Key",
                "tags": [
                "account"
            ]
        }
    },
    "/account/checklogin": {
        "get": {
            "responses": {
                "200": {
                    "description": "\"status\": \"success\", \"login\" : \"success\", \"user_id\" : \"{user_id}\""
                },
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "User email for login",
                    "type": "string",
                    "name": "email",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "User password encrypted by bcrypt",
                    "type": "string",
                    "name": "password",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get all user data",
                "tags": [
                "account"
            ]
        }
    },
    "/admin/user/{user_id}": {
        "delete": {
            "responses": {
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "user_id",
                    "in": "path"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "0",
                    "required": false,
                    "description": "Set a user soft delete or real delete",
                    "type": "boolean",
                    "name": "is_deleted",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/xml",
                "application/json"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Delete a user",
                "tags": [
                "admin-user"
            ]
        },
        "put": {
            "responses": {
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "user_id",
                    "in": "path"
                },
                {
                    "required": false,
                    "description": "User email for login",
                    "type": "string",
                    "name": "email",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User password encrypted by bcrypt",
                    "type": "string",
                    "name": "password",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User name",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User phone",
                    "type": "string",
                    "name": "phone",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User gender",
                    "type": "string",
                    "name": "gender",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User role",
                    "type": "string",
                    "name": "role",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/xml",
                "application/json"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Update user details by id",
                "tags": [
                "admin-user"
            ]
        },
        "get": {
            "responses": {
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "",
                    "type": "integer",
                    "name": "user_id",
                    "in": "path"
                }
            ],
                "produces": [
                "application/xml",
                "application/json"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get user by id",
                "tags": [
                "admin-user"
            ]
        }
    },
    "/admin/user": {
        "post": {
            "responses": {
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "User email for login",
                    "type": "string",
                    "name": "email",
                    "in": "formData"
                },
                {
                    "required": true,
                    "description": "User password encrypted by bcrypt",
                    "type": "string",
                    "name": "password",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User name",
                    "type": "string",
                    "name": "name",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User phone",
                    "type": "string",
                    "name": "phone",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User gender",
                    "type": "string",
                    "name": "gender",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "User role",
                    "type": "string",
                    "name": "role",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Create user",
                "tags": [
                "admin-user"
            ]
        },
        "get": {
            "responses": {
                "500": {
                    "description": "\"status\": \"error\","
                }
            },
            "parameters": [
                {
                    "required": true,
                    "description": "For authentication",
                    "type": "string",
                    "name": "api-key",
                    "in": "formData"
                },
                {
                    "enum": [
                        "1",
                        "0"
                    ],
                    "default": "0",
                    "required": false,
                    "description": "",
                    "type": "boolean",
                    "name": "is_deleted",
                    "in": "formData"
                },
                {
                    "required": false,
                    "description": "",
                    "type": "string",
                    "name": "created_at",
                    "in": "formData"
                }
            ],
                "produces": [
                "application/json",
                "application/xml"
            ],
                "consumes": [
                "application/x-www-form-urlencoded"
            ],
                "summary": "Get all user data",
                "tags": [
                "admin-user"
            ]
        }
    }
},
    "schemes": [
    "https",
    "http"
],
    "tags": [
    {
        "description": "Admin manages user's actions",
        "name": "admin-user"
    },
    {
        "description": "User manages their account information",
        "name": "account"
    },
    {
        "description": "Hotel actions made by user",
        "name": "hotel"
    },
    {
        "description": "Booking action made by user",
        "name": "booking"
    },
    {
        "description": "Searching API",
        "name": "search"
    },
    {
        "description": "Admin manages hotel information",
        "name": "admin-hotel"
    },
    {
        "description": "Admin manages client Booking & Payment",
        "name": "admin-booking-payment"
    },
    {
        "description": "Admin manages hotel categories",
        "name": "admin-category"
    },
    {
        "description": "Admin manages hotel tags",
        "name": "admin-tags"
    },
    {
        "description": "Admin manages payment methods",
        "name": "admin-paymethod"
    },
    {
        "description": "Admin get statistic",
        "name": "admin-statistic"
    },
    {
        "description": "Admin manages config",
        "name": "admin-config"
    }
],
    "basePath": "/index.php",
    "info": {
    "license": {
        "url": "http://google.com",
            "name": "KenIp"
    },
    "contact": {
        "email": "kenip0813@gmail.com"
    },
    "termsOfService": "http://swagger.io/terms/",
        "title": "HotelsDB API Documentation",
        "version": "1.0.0",
        "description": "This is Hotelsdb API Documentation. You can find out all of the restful api here.\nFor more information, please contact out chief software engineer **Ken Ip** by email. \n \n\n# Introduction\nThis API is documented in **Swagger format** and is based on Hotelsdb website content provided by **Hotelsdb development team.** \n Currently, Hotelsdb API is not released for public use. It only provides API specification for developer to read and test. \n For internal use, each of the api required `API-KEY` do authentication. Error message will display without the key.",
        "x-logo": {
        "url": "public/images/logo/api.png",
            "altText": "Hotelsdb"
    }
},
    "swagger": "2.0"
}