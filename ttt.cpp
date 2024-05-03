#include "ttt.h"
#include "ui_ttt.h"
#include "client.h"

ttt::ttt(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::ttt)
{
    ui->setupUi(this);
}

ttt::~ttt()
{
    delete ui;
}
