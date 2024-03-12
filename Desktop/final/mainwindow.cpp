#include "mainwindow.h"
#include "ui_mainwindow.h"
#include "ajout.h"
#include "partenaire.h"
#include"suppression.h"
#include <QPdfWriter>
#include <QPrinter>
#include <QPainter>
#include <QMessageBox>
#include <QTableView>
#include <QAbstractItemModel>
#include <QUrl>
#include <QDesktopServices>
#include <QGraphicsView>
#include <QGraphicsScene>



MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);




    ui->listEmployetableView->setModel(p.afficher());
}

MainWindow::~MainWindow()
{
    delete ui;
}

void MainWindow::on_pushButton_clicked()
{
    ajout a;
    a.exec();
}


void MainWindow::on_pushButton_2_clicked()
{
    suppression s;
    s.exec();

}


void MainWindow::on_pushButton_3_clicked()
{
    partenaire p("","","","","","","");

       ui->listEmployetableView->setModel(p.afficher());
}

bool MainWindow::modifiercontrat(const QString& dureeContrat, const QString& nouveaudureeContrat)
{
    partenaire p;
    return p.modifiercontrat(dureeContrat, nouveaudureeContrat);
}

void MainWindow::on_pushButton_4_clicked()
{
    // Récupérer le nom et le nouveau prénom depuis l'interface utilisateur
    QString contrat = ui->contrat_LE->text(); // Rename the variable to avoid shadowing
    QString nouveaudureeContrat = ui->nouveaucontrat_LE->text();

    // Appeler la fonction de modification du prénom du partenaire en utilisant le nom comme critère de sélection
    bool success =  modifiercontrat(contrat, nouveaudureeContrat);

    // Vérifier si la modification a réussi et afficher un message en conséquence
    if (success) {
        QMessageBox::information(this, "Succès", "Modification de la durée du contrat réussie !");
    } else {
        QMessageBox::warning(this, "Erreur", "La modification du contrat  n'a pas pu être effectuée.");
    }
}

/*void MainWindow::on_pushButton_5_clicked()
{
    QString matriculeFiscale = ui->recherche_LE->text().trimmed(); // Récupérer le matricule fiscale entré par l'utilisateur

    if (!matriculeFiscale.isEmpty()) { // Vérifier si le matricule fiscale n'est pas vide
        QSqlQueryModel* model = new QSqlQueryModel();
        QSqlQuery query;
        query.prepare("SELECT * FROM FOOL WHERE MATRICULE_FISCALE = ?");
        query.addBindValue(matriculeFiscale);

        if (query.exec()) { // Exécuter la requête SQL
            model->setQuery(query);
            ui->listEmployetableView->setModel(model); // Afficher les résultats dans la vue de table
        } else {
            // Gérer les erreurs d'exécution de la requête
        }
    } else {
        // Si le matricule fiscale est vide, afficher tous les enregistrements
        partenaire p;
        ui->listEmployetableView->setModel(p.afficher());
    }
}
*/
/*void MainWindow::on_lineEdit_textChanged(const QString &arg1)
{
    if(arg1.isEmpty())
    {
          QSqlQueryModel* model = new QSqlQueryModel();
        partenaire p;
       ui->listEmployetableView->setModel(model);
    }
}*/





void MainWindow::on_pushButton_6_clicked()
{
    // Créez une instance de la classe partenaire
    partenaire p;

    // Appelez la fonction TriPar avec le critère "DUREE_CONTRAT"
    QSqlQueryModel* model = p.TriPar("DUREE_CONTRAT");

    // Vérifiez si le modèle est valide avant de le définir sur votre vue
    if (model) {
        ui->listEmployetableView->setModel(model);
    } else {
        // Gérer l'échec de la création du modèle
        qDebug() << "Échec de la création du modèle de tri.";
        // Vous pouvez afficher un message d'erreur à l'utilisateur si nécessaire
    }

}


void MainWindow::on_pushButton_7_clicked()
{
    // Création d'un objet QPrinter + configuration pour avoir un fichier PDF
    QPrinter printer;
    printer.setOutputFormat(QPrinter::PdfFormat);
    printer.setOutputFileName("C:\\Users\\MSI\\Desktop\\final\\listepartenaires.pdf");

    // Création d'un objet QPainter pour l'objet QPrinter
    QPainter painter;
    if (!painter.begin(&printer)) {
        qWarning("Failed to open file, is it writable?");
        return;
    }

    // Obtenir le modèle de la table à partir de la QTableView
    QAbstractItemModel *model = ui->listEmployetableView->model();

    // Obtenir les dimensions de la table
    int rows = model->rowCount();
    int columns = model->columnCount();

    // Définir la taille de la cellule pour le dessin
    int cellWidth = 100;
    int cellHeight = 30;

    // Insérer les noms des colonnes
    for (int col = 0; col < columns; ++col) {
        QString headerData = model->headerData(col, Qt::Horizontal).toString();
        painter.drawText(col * cellWidth, 0, cellWidth, cellHeight, Qt::AlignCenter, headerData);
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
    }

    // Terminer avec QPainter
    painter.end();

    // Afficher un QMessageBox pour indiquer que le fichier a été enregistré
    QMessageBox::information(this, "Enregistrement réussi", "La liste a été enregistrée . Merci de consulter votre dossier.");
}













void MainWindow::on_recherche_LE_textEdited(const QString &searchText)
{

    ui->listEmployetableView->setModel(p.recherche_MATRICULE_FISCALE(searchText));

}

