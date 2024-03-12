#include "ajout.h"
#include "ui_ajout.h"
#include <QMessageBox>
#include "partenaire.h"
ajout::ajout(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::ajout)
{
    ui->setupUi(this);
}

ajout::~ajout()
{
    delete ui;
}

void ajout::on_pushButton_clicked()
{
    QString matriculeFiscale = ui->matriculeFiscale_LE->text();
    QString nomEntreprise = ui->nomEntreprise_LE->text();
    QString numeroTelephone = ui->numeroTelephone_LE->text();
     QString adresse = ui->adresse_LE->text();
    QString dureeContrat = ui->dureeContrat_LE->text();
    QString secteurActivite = ui->secteurActivite_LE->text();
    QString interet = ui->interet_TE->toPlainText();

    partenaire p( matriculeFiscale,nomEntreprise, adresse, numeroTelephone, dureeContrat, secteurActivite, interet);
    bool test = p.ajouter();

    if (test) {
        QMessageBox::information(this, "Succès", "Ajout effectué avec succès!");
    } else {
        QMessageBox::warning(this, "Erreur", "L'ajout n'a pas pu être effectué.");
    }

}

