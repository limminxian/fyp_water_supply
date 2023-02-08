package com.example.technician;

import java.time.LocalDate;
import java.util.Date;

public class TaskModel {
    int ticketID;
    String name;
    String type;
    String description;
    String street;
    String blockNo;
    String unitNo;
    int postalCode;
    String status;
    String area;
    LocalDate serviceDate;

    public TaskModel(int ticketID, String name, String type, String description, String street, String blockNo, String unitNo, int postalCode, String status, String area, LocalDate serviceDate) {
        this.ticketID = ticketID;
        this.name = name;
        this.type = type;
        this.description = description;
        this.street = street;
        this.blockNo = blockNo;
        this.unitNo = unitNo;
        this.postalCode = postalCode;
        this.status = status;
        this.area = area;
        this.serviceDate = serviceDate;
    }


    public String getStreet() {
        return street;
    }

    public String getBlockNo() {
        return blockNo;
    }

    public String getUnitNo() {
        return unitNo;
    }

    public int getPostalCode() {
        return postalCode;
    }

    public String getName() {
        return name;
    }

    public String getStatus() {
        return status;
    }

    public String getDescription() {
        return description;
    }

    public String getType() {
        return type;
    }

    public String getArea() {return area;}

    public LocalDate getServiceDate() {
        return serviceDate;
    }

    public void setArea(String area) {
        this.area = area;
    }

    public int getTicketID() {
        return ticketID;
    }

    public void setStatus(String status) {
        this.status = status;
    }
}
