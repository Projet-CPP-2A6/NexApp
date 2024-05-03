#include "add.h"
#include "ui_add.h"
#include <QMessageBox>
#include <QFileDialog>
#include"partenaire.h"

add::add(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::add)
{
    ui->setupUi(this);
}

add::~add()
{
    delete ui;
}

void add::on_pushButton_clicked()
{

    QString matriculeFiscale = ui->matriculeFiscale_LE->text();
    QString nomEntreprise = ui->nomEntreprise_LE->text();
    QString numeroTelephone = ui->numeroTelephone_LE->text();
    QString adresse = ui->adresse_LE->text();
    QDate debutContrat = ui->debutContrat_DateEdit->date(); // Utilisation de QDate pour debutContrat
    QDate finContrat = ui->finContrat_DateEdit->date();     // Utilisation de QDate pour finContrat
    QString secteurActivite = ui->secteurActivite_LE->text();
    QString interet = ui->interet_TE->toPlainText();

    // Vérifier si un chemin d'image a été saisi
    QString cheminImage = ui->lineEditCheminImage->text();

    // Si un chemin d'image est valide, créer un objet partenaire et l'ajouter
    if (!cheminImage.isEmpty()) {
        Partenaire P(matriculeFiscale, nomEntreprise, adresse, numeroTelephone, debutContrat, finContrat, secteurActivite, interet, cheminImage);
        bool test = P.ajouter();

        if (test) {
            QMessageBox::information(this, "Succès", "Ajout effectué avec succès!");
        } else {
            QMessageBox::warning(this, "Erreur", "L'ajout n'a pas pu être effectué.");
        }
    } else {
        QMessageBox::warning(this, "Attention", "Veuillez sélectionner une image avant de valider.");
    }

}


void add::on_pushButton_2_clicked()
{
    QString imagePath = QFileDialog::getOpenFileName(this, "Sélectionner une image", "", "Images (*.png *.jpg *.jpeg *.bmp)");
    if (!imagePath.isEmpty()) {
        QPixmap image(imagePath);
        if (!image.isNull()) {
            ui->labelApercuImage->setPixmap(image.scaled(ui->labelApercuImage->size(), Qt::KeepAspectRatio)); // Afficher l'image dans le QLabel
            ui->labelApercuImage->setAlignment(Qt::AlignCenter); // Centrer l'image dans le QLabel
            ui->labelApercuImage->setScaledContents(true); // Redimensionner l'image pour s'adapter au QLabel
            ui->lineEditCheminImage->setText(imagePath); // Afficher le chemin de l'image dans un lineEdit (facultatif)
        } else {
            qDebug() << "Impossible de charger l'image.";
        }
    }
}


void add::on_pushButton_3_clicked()
{
    this->close();

}

