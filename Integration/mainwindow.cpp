#include "mainwindow.h"
#include "ui_mainwindow.h"
#include "aminee.h"
#include "nour.h"
#include "chrif.h"

#include"interface.h"

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
}

MainWindow::~MainWindow()
{
    delete ui;
}

void MainWindow::on_pushButton_4_clicked()
{
    interface i;
    i.exec();
}


void MainWindow::on_pushButton_3_clicked()
{
    nour n;
    n.exec();

}


void MainWindow::on_pushButton_5_clicked()
{
    aminee a;
    a.exec();
}


void MainWindow::on_pushButton_10_clicked()
{
    chrif c;
    c.exec();
}



