#include "modif.h"
#include "ui_modif.h"
#include "partenaire.h"
#include <QMessageBox>
#include"modif.h"

modif::modif(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::modif)
{
    ui->setupUi(this);
}

modif::~modif()
{
    delete ui;
}





