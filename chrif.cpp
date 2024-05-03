#include "chrif.h"
#include "client.h"
#include "ui_chrif.h"
#include "ajouch.h"
#include"client.h"
#include <QPdfWriter>
#include <QPainter>
#include <QMessageBox>
#include <QTableView>
#include <QAbstractItemModel>
#include <QUrl>
#include <QDesktopServices>
#include <QGraphicsView>
#include <QGraphicsScene>
#include <QSqlQueryModel>
#include <QModelIndex>
#include <QPdfWriter>
#include <QPrinter>
#include "modifch.h"
#include "supprich.h"
#include"statch.h"
#include"arduino.h"
#include "ttt.h"
#include <QDateTime>


chrif::chrif(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::chrif)
{
    ui->setupUi(this);

    if (A.connect_arduino()) {
       qDebug() << "adruino mrgl ! " ;
      }

    QObject::connect(A.getserial(), SIGNAL(readyRead()), this, SLOT(verifyID()));


    ui->listEmployetableView->setModel(l.afficher());
}

chrif::~chrif()
{
    delete ui;
}

void chrif::on_pushButton_8_clicked()
{
    ajouch a;
    a.exec();

}


void chrif::on_pushButton_10_clicked()
{
    modifch f;
    f.exec();
}



void chrif::on_pushButton_9_clicked()
{
    supprich s;
    s.exec();
}


void chrif::on_pushButton_11_clicked()
{
    Client nouveauconstat;

    ui->listEmployetableView->setModel(l.afficher());
}


void chrif::on_pushButton_12_clicked()
{
    QPrinter printer;
    printer.setOutputFormat(QPrinter::PdfFormat);
    printer.setOutputFileName("C:\\Users\\MSI\\Desktop\\travailQt\\Integration\\listeclients.pdf");

    // Création d'un objet QPainter pour l'objet QPrinter
    QPainter painter;
    if (!painter.begin(&printer)) {
        qWarning("Failed to open file, is it writable?");
        return;
    }

    // Définition des styles
    QFont font("Arial", 7);
    painter.setFont(font);

    // Obtenir le modèle de la table à partir de la QTableView
    QAbstractItemModel *model = ui->listEmployetableView->model();

    // Obtenir les dimensions de la table
    int rows = model->rowCount();
    int columns = model->columnCount();

    // Définir la taille de la cellule pour le dessin
    int cellWidth = 100;
    int cellHeight = 40;

    // Insérer les noms des colonnes et dessiner des lignes verticales
    for (int col = 0; col < columns; ++col) {
        QString headerData = model->headerData(col, Qt::Horizontal).toString();
        painter.drawText(col * cellWidth, 0, cellWidth, cellHeight, Qt::AlignCenter, headerData);
        painter.drawLine(col * cellWidth, 0, col * cellWidth, rows * cellHeight); // Dessiner une ligne verticale
    }

    // Insérer les données de la table sur le périphérique de sortie PDF
    for (int row = 1; row < rows; ++row) {
        for (int col = 0; col < columns; ++col) {
            // Obtenir les données de la cellule
            QModelIndex index = model->index(row, col);
            QString data = model->data(index).toString();

            // Insérer les données de la cellule
            painter.drawText(col * cellWidth, row * cellHeight, cellWidth, cellHeight, Qt::AlignLeft, data);
        }
        // Dessiner une ligne horizontale après chaque ligne de données
        painter.drawLine(0, row * cellHeight, columns * cellWidth, row * cellHeight);
    }

    // Terminer avec QPainter
    painter.end();

    // Afficher un QMessageBox pour indiquer que le fichier a été enregistré
    QMessageBox::information(this, "Enregistrement réussi", "La liste a été enregistrée. Merci de consulter votre dossier.");

}



void chrif::on_lineEdit_textEdited(const QString &searchText)
{
    bool rechercheParCIN = true; // Définissez cela en fonction de vos besoins

    // Appelez la fonction rechercheClient de l'objet client
    QStandardItemModel* modelRecherche = l.rechercheClient(searchText, rechercheParCIN);

    // Définissez le modèle retourné comme modèle pour le QTableView
    ui->listEmployetableView->setModel(modelRecherche);
}


void chrif::on_pushButton_13_clicked()
{
    Client nouveauClient;

    // Appeler la fonction TriPar pour obtenir le modèle de requête SQL trié
    QSqlQueryModel* model = nouveauClient.TriPar("NOM");

    if (model) {
        // Afficher le modèle de requête SQL dans le QTableView
        ui->listEmployetableView->setModel(model);
    } else {
        // Afficher un message d'erreur si le modèle est nul
        QMessageBox::warning(this, "Erreur", "Impossible de trier les données.");
    }
}


void chrif::on_pushButton_16_clicked()
{
    statch t;
    t.exec();

}


void chrif::on_pushButton_15_clicked()
{
    check_id() ;
}

void chrif::check_id(){
    QSqlQuery q1,q2 ;
    QByteArray reply = A.read_from_arduino() ;

    QString str(reply) ;
    int i = 0 ;


    q1.prepare("SELECT * FROM CLIENTS WHERE CIN = :ref ") ;
    q1.bindValue(":ref",str) ;

    if(q1.exec()){
        if(q1.next()){
            i++ ;
        }
    }
    if(i) {
        qDebug() << "mawjud" ;
        A.write_to_arduino("1");

        QString name = q1.value(1).toString() ;
        A.write_to_arduino(name.toUtf8()) ;


        QDateTime currentDateTime = QDateTime::currentDateTime();
        QString currentTimeString = currentDateTime.toString("hh:mm:ss");
        ui->label->setText("access granted for id : " + q1.value(0).toString() + " time : " + currentTimeString) ;
        q2.prepare("UPDATE CLIENTS SET DATE_ARRIVE = :dt WHERE CIN = :id") ;
        q2.bindValue(":dt",currentTimeString) ;
        q2.bindValue(":id",str) ;
        if(q2.exec()) {
            qDebug() << "t9ayed fl db ! " ;

        }
    }
    else{
        qDebug() << "mahush mawjud ! " ;
       A.write_to_arduino("0") ;
       ui->label->setText("access denied ! ") ;
    }

}
