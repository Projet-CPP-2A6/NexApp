#include "mainwindow.h"
#include "connection.h"
#include <QApplication>
#include <QMessageBox>

int main(int argc, char *argv[])
{
    QApplication a(argc, argv);
    MainWindow w;
    Connection d ;

    if (d.createconnection()){
        w.show();
    }
    else {
        QMessageBox::information(nullptr, "Connection Error", "Failed to connect to the database.");
    }

    return a.exec();
}
