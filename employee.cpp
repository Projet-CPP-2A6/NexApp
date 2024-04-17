#include "employee.h"
#include "ui_employee.h"

employee::employee(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::employee)
{
    ui->setupUi(this);
}

employee::~employee()
{
    delete ui;
}
