#include "mainwindow.h"
#include "ui_mainwindow.h"
#include "aminee.h"
#include "nour.h"
#include "chrif.h"
#include <QRegularExpression>
#include"interface.h"

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    if (A.connect_arduino() == 0 )  {
        qDebug() << "connected mrgl " ;
    }
    QObject::connect(A.getserial(),SIGNAL(readyRead()),this,SLOT(checkRFIDCard()));
}
void MainWindow::checkRFIDCard()
{
    static QString accumulatedData; // Static variable to accumulate data

    // Read the IDCARD from Arduino
    QByteArray newData = A.read_from_arduino();
    QString cleanedData = QString::fromUtf8(newData).remove(QRegularExpression("[\\n\\r\\t]"));

    // Accumulate the cleaned data
    accumulatedData += cleanedData;

    // Check if the accumulated data length is the expected length for an IDCARD
    if (accumulatedData.length() == 8) { // Assuming IDCARD length is 8
        QString IDCARD = accumulatedData.trimmed(); // Clean up the IDCARD
        qDebug() << "IDCARD:" << IDCARD;
        QSqlQuery query;
        query.prepare("SELECT NOM, PRENOM, cine FROM EMPLOYE WHERE IDCCARD = :IDCARD"); // Correctly format the column name
        query.bindValue(":IDCARD", IDCARD);

        if (!query.exec()) {
            qDebug() << "Query execution failed:" << query.lastError().text();
            return;
        }

        if (query.next()) {
            QString name = query.value(0).toString();
            QString surname = query.value(1).toString();
            int cine = query.value(2).toInt();
            QString cin = QString::number(cine); // Convert integer to QString

            // Construct the message to send to Arduino
            QByteArray message =  cin.toUtf8() +" "+ name.toUtf8() ;
            A.write_to_arduino(message);
        } else {
            QString noMatchMessage = "Access Denied";
            A.write_to_arduino(noMatchMessage.toUtf8());
        }

        // Clear the accumulated data after processing
        accumulatedData.clear();
    }
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

void MainWindow::on_pushButton_clicked()
{
    qDebug() << A.read_from_arduino() ;
}

