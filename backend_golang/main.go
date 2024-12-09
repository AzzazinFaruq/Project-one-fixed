package main

import (
	"backend_golang/controllers"
	"backend_golang/middlewares"
	"backend_golang/setup"

	"github.com/gin-gonic/gin"
)

func main() {
	//Declare New Gin Route System
	router := gin.New()
	router.Use(middleware.CORSMiddleware())
	//Run Database Setup
	setup.ConnectDatabase()
	

	//Auth
	router.POST("/register", controllers.Register)
	router.POST("/login", controllers.Login)

	protected := router.Group("/api")
	protected.Use(middleware.AuthMiddleware())

	//User
	protected.POST("/logout", controllers.Logout)
	protected.GET("/user", controllers.GetCurrentUser)

	router.Run(":8080")
}
