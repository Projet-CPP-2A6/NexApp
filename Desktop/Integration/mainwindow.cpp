#include "mainwindow.h"
#include "ui_mainwindow.h"
#include "nour.h"
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

