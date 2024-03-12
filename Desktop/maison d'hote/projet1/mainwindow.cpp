#include "Error in " Util.relativeFilePath('C:/Users/MSI/Desktop/maison d'hote/mainwindow.h', 'C:/Users/MSI/Desktop/maison d'hote' + '/' + Util.path('mainwindow.cpp'))": SyntaxError: Expected token `)'"
#include "ui_mainwindow.h"

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

