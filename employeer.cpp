#include "employeer.h"
#include "ui_employeer.h"

employeer::employeer(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::employeer)
{
    ui->setupUi(this);
}

employeer::~employeer()
{
    delete ui;
}
