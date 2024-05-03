#include "aminee.h"
#include "ui_aminee.h"
#include "modifa.h"
#include "supprima.h"
#include "constat.h"
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
#include "pluss.h"
#include "stata.h"

aminee::aminee(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::aminee)
{
    ui->setupUi(this);
   ui->listEmployetableView->setModel(c.afficher());
}

aminee::~aminee()
{
    delete ui;
}

void aminee::on_pushButton_8_clicked()
{
    pluss p;
    p.exec();
}


void aminee::on_pushButton_10_clicked()
{
    modifa f;
    f.exec();
}


void aminee::on_pushButton_9_clicked()
{
    supprima s;
    s.exec();

}


void aminee::on_pushButton_12_clicked()
{
    QPrinter printer;
    printer.setOutputFormat(QPrinter::PdfFormat);
    printer.setOutputFileName("C:\\Users\\MSI\\Desktop\\travailQt\\Integration\\listeconstats.pdf");

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


void aminee::on_pushButton_13_clicked()
{
    constat nouveauconstat;

    // Appeler la fonction TriPar pour obtenir le modèle de requête SQL trié
    QSqlQueryModel* model = nouveauconstat.TriPar("TYPE_CONSTAT");

    if (model) {
        // Afficher le modèle de requête SQL dans le QTableView
        ui->listEmployetableView->setModel(model);
    } else {
        // Afficher un message d'erreur si le modèle est nul
        QMessageBox::warning(this, "Erreur", "Impossible de trier les données.");
    }

}


void aminee::on_pushButton_11_clicked()
{
    constat nouveauconstat;

    ui->listEmployetableView->setModel(c.afficher());
}


void aminee::on_lineEdit_textEdited(const QString &searchText)
{
    bool rechercheParID = true; // Vous devez définir cela en fonction de vos besoins

    // Appelez la fonction recherche de l'objet constat
    QStandardItemModel* modelRecherche = c.recherche(searchText, rechercheParID);

    // Définissez le modèle retourné comme modèle pour le QTableView
    ui->listEmployetableView->setModel(modelRecherche);
}


void aminee::on_pushButton_16_clicked()
{
    stata t;
    t.exec();
}

