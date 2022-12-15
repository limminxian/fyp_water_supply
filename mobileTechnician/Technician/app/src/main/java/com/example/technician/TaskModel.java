package com.example.technician;

public class TaskModel {
    String homeownerName;
    String serviceType;
    String description;
    String address;
    String status;
    int image;

    public TaskModel(String homeownerName, String serviceType, String description, String address, String status, int image) {
        this.homeownerName = homeownerName;
        this.serviceType = serviceType;
        this.description = description;
        this.address = address;
        this.status = status;
        this.image = image;
    }

    public String getHomeownerName() {
        return homeownerName;
    }

    public String getServiceType() {
        return serviceType;
    }

    public String getDescription() {
        return description;
    }

    public String getAddress() {
        return address;
    }

    public String getStatus() {
        return status;
    }

    public int getImage() {
        return image;
    }
}
