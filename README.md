# Elements
[![Build Status](https://travis-ci.com/GRAYZ16/Elements.svg?token=ZVVMT9TUfZ5AyCRYJD4h&branch=master)](https://travis-ci.com/GRAYZ16/Elements)

General Purpose REST API and front-end web app built for leveraging abilities of IOT devices. Provides a generic and full featured REST API, built in nodejs, that allows interactivity between web applications and individual devices.

## Getting Started
Docker containers are leveraged to provide the ability for end-users to build production ready Elements nodes with fairly simple installs.

The requirements of the Elements system are:

  - **Docker -** MongoDB and the REST API are hosted within to enable ease of compatability over all development systems.
  - **Nodejs -** Node is utilised for REST functionality through the use of ExpressJS. It also interfaces with MongoDB through relevant connectors.
  - **MongoDB -** Data is stored within Elements through the use of MongoDB. The data storage process is streamlined between field validation at the REST API ingress and JSON Schema validation at egress to ensure data integrity.
  - **Travis CI -** Travis CI is used for Continous Integration testing for the project. When required, this area will be updated with more information on test suites and pass/fail criteria. 

## Features
The following is a baseline of the intended features of Elements as a guide toward the intended application and overall featureset of the system. 
  - Interface to IOT Devices (Intending use with ESP8266 based devices using MQTT)
  - Data collection and Storage (MQTT communications to MongoDB storage)
  - Data visualisation and control (Time-series graphing/Data Collection)
