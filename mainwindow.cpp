#include "mainwindow.h"
#include "ui_mainwindow.h"
#include "aminee.h"
#include "nour.h"
#include<QDate>
#include "chrif.h"
#include <QRegularExpression>
#include"interface.h"
#include <QDateTime>
#include "pointagee.h"
#include <QMessageBox>

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    /*
    if (A.connect_arduino() == 0 )  {
        qDebug() << "connected mrgl " ;
    }
    */
    QObject::connect(A.getserial(),SIGNAL(readyRead()),this,SLOT(checkRFIDCard()));
}
/*void MainWindow::checkRFIDCard()
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
       query.prepare("SELECT CINE,NOM, PRENOM FROM EMPLOYEEE WHERE IDCARD = :IDCARD"); // Correctly format the column name
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
}*/
/*void MainWindow::checkRFIDCard()
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
        query.prepare("SELECT CINE, NOM, PRENOM FROM EMPLOYEEE WHERE IDCARD = :IDCARD"); // Correctly format the column name
        query.bindValue(":IDCARD", IDCARD);

        if (!query.exec()) {
            qDebug() << "Query execution failed:" << query.lastError().text();
            A.write_to_arduino("Query execution failed"); // Send a message to Arduino for debugging
            return;
        }

        if (query.next()) {
            QString name = query.value(1).toString();
            QString surname = query.value(2).toString();
            int cine = query.value(0).toInt();
            QString cin = QString::number(cine);            // Convert integer to QString
            QMessageBox::information(this, "Greeting", "Bonjour " + name + " " + surname);


            // Construct the message to send to Arduino
            QByteArray message = cin.toUtf8() + " " + name.toUtf8() + " " + surname.toUtf8();
            A.write_to_arduino(message);
        } else {
            QString noMatchMessage = "No matching record found";
            qDebug() << noMatchMessage;
            A.write_to_arduino(noMatchMessage.toUtf8());
        }

        // Clear the accumulated data after processing
        accumulatedData.clear();
    }
}*/


/*void MainWindow::checkRFIDCard()
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
        query.prepare("SELECT CINE, NOM, PRENOM FROM EMPLOYEEE WHERE IDCARD = :IDCARD"); // Correctly format the column name
        query.bindValue(":IDCARD", IDCARD);

        if (!query.exec()) {
            qDebug() << "Query execution failed:" << query.lastError().text();
            A.write_to_arduino("Query execution failed"); // Send a message to Arduino for debugging
            return;
        }

        if (query.next()) {
            QString name = query.value(1).toString();
            QString surname = query.value(2).toString();
            int cine = query.value(0).toInt();
            QString cin = QString::number(cine);            // Convert integer to QString

            // Get the current system time
            QString currentTime = QDateTime::currentDateTime().toString("hh:mm:ss");

            // Construct the message to send to Arduino
            QString message = "Bonjour " + name + " " + surname + ". Heure actuelle: " + currentTime;
            QByteArray messageData = message.toUtf8();
            QMessageBox::information(this, "Greeting", message);

            A.write_to_arduino(messageData);
        } else {
            QString noMatchMessage = "No matching record found";
            qDebug() << noMatchMessage;
            A.write_to_arduino(noMatchMessage.toUtf8());
        }

        // Clear the accumulated data after processing
        accumulatedData.clear();
    }
}*/

/*void MainWindow::checkRFIDCard()
{
    static QString accumulatedData; // Variable statique pour accumuler les données

    // Lire l'IDCARD depuis Arduino
    QByteArray newData = A.read_from_arduino();
    QString cleanedData = QString::fromUtf8(newData).remove(QRegularExpression("[\\n\\r\\t]"));

    // Accumuler les données nettoyées
    accumulatedData += cleanedData;

    // Vérifier si la longueur des données accumulées correspond à la longueur attendue pour une IDCARD
    if (accumulatedData.length() == 8) { // En supposant que la longueur de l'IDCARD est de 8
        QString IDCARD = accumulatedData.trimmed(); // Nettoyer l'IDCARD
        qDebug() << "IDCARD:" << IDCARD;

        // Obtenir l'heure système actuelle
        QString currentTime = QDateTime::currentDateTime().toString("yyyy-MM-dd hh:mm:ss");

        QSqlQuery query;
        query.prepare("SELECT CINE, NOM, PRENOM FROM EMPLOYEEE WHERE IDCARD = :IDCARD"); // Formater correctement le nom de la colonne
        query.bindValue(":IDCARD", IDCARD);

        if (!query.exec()) {
            qDebug() << "Échec de l'exécution de la requête:" << query.lastError().text();
            A.write_to_arduino("Échec de l'exécution de la requête"); // Envoyer un message à Arduino pour le débogage
            return;
        }

        if (query.next()) {
            QString name = query.value(1).toString();
            QString surname = query.value(2).toString();
            int cine = query.value(0).toInt();
            QString cin = QString::number(cine);            // Convertir un entier en QString

            // Construire le message à envoyer à Arduino
            QString message = "Bonjour " + name + " " + surname + ". Heure actuelle: " + currentTime;
            QByteArray messageData = message.toUtf8();
            QMessageBox::information(this, "Salutation", message);

            A.write_to_arduino(messageData);




            // Insérer une nouvelle ligne avec l'heure actuelle dans la colonne HE de la base de données
            QSqlQuery updateQuery;
            updateQuery.prepare("UPDATE EMPLOYEEE SET HE = :heure WHERE IDCARD = :IDCARD");
            updateQuery.bindValue(":IDCARD", IDCARD);
            updateQuery.bindValue(":heure", currentTime);

            if (!updateQuery.exec()) {
                qDebug() << "Failed to update HE column:" << updateQuery.lastError().text();
            }

        } else {
            QString noMatchMessage = "Aucun enregistrement correspondant trouvé";
            qDebug() << noMatchMessage;
            A.write_to_arduino(noMatchMessage.toUtf8());
        }

        // Effacer les données accumulées après le traitement
        accumulatedData.clear();
    }
}
*/

void MainWindow::checkRFIDCard()
{
    static QString accumulatedData; // Variable statique pour accumuler les données

    // Lire l'IDCARD depuis Arduino
    QByteArray newData = A.read_from_arduino();
    QString cleanedData = QString::fromUtf8(newData).remove(QRegularExpression("[\\n\\r\\t]"));

    // Accumuler les données nettoyées
    accumulatedData += cleanedData;

    // Vérifier si la longueur des données accumulées correspond à la longueur attendue pour une IDCARD
    if (accumulatedData.length() == 8) {
        QString IDCARD = accumulatedData.trimmed(); // Nettoyer l'IDCARD
        qDebug() << "IDCARD:" << IDCARD;

        if (IDCARD == "33878BDC") {
            // Show the pointagee interface
           // pointagee p;
           // p.exec();
        }

        // Get current time (only time part) for both entry and exit
        QString currentTime = QTime::currentTime().toString("hh:mm:ss");

        // Fetch current entry and exit times
        QString entryTime, exitTime;
        QSqlQuery fetchTimesQuery;
        fetchTimesQuery.prepare("SELECT HE_ENTREE, HE_SORTIE FROM EMPLOYEEE WHERE IDCARD = :IDCARD");
        fetchTimesQuery.bindValue(":IDCARD", IDCARD);

        if (fetchTimesQuery.exec() && fetchTimesQuery.next()) {
            entryTime = fetchTimesQuery.value(0).toString();
            exitTime = fetchTimesQuery.value(1).toString();
        }

        // Determine message based on entry and exit status
        QString message;
        if (entryTime.isEmpty() && exitTime.isEmpty()) {
            // New entry
            message = "Bonjour "  ". Heure d'entrée: " + currentTime;
            // Update HE_ENTREE
            QSqlQuery updateEntryQuery;
            updateEntryQuery.prepare("UPDATE EMPLOYEEE SET HE_ENTREE = :currentTime WHERE IDCARD = :IDCARD");
            updateEntryQuery.bindValue(":IDCARD", IDCARD);
            updateEntryQuery.bindValue(":currentTime", currentTime);

            if (!updateEntryQuery.exec()) {
                qDebug() << "Failed to update HE_ENTREE:" << updateEntryQuery.lastError().text();
            }
        } else if (!entryTime.isEmpty() && exitTime.isEmpty()) {
            // Exit
            message = "Bye Bye "  ". Heure de sortie: " + currentTime;
            // Update HE_SORTIE
            QSqlQuery updateExitQuery;
            updateExitQuery.prepare("UPDATE EMPLOYEEE SET HE_SORTIE = :currentTime WHERE IDCARD = :IDCARD");
            updateExitQuery.bindValue(":IDCARD", IDCARD);
            updateExitQuery.bindValue(":currentTime", currentTime);

            if (!updateExitQuery.exec()) {
                qDebug() << "Failed to update HE_SORTIE:" << updateExitQuery.lastError().text();
            }
        } else {
            // Already exited
            message = "Vous avez déjà enregistré votre sortie.";
        }

        // Display message and write to Arduino
        QMessageBox::information(this, message.split(" ")[0], message);
        A.write_to_arduino(message.toUtf8());

        // Clear accumulated data
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




