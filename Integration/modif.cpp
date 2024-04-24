#include "modif.h"
#include "ui_modif.h"
#include <QMessageBox>
#include "partenaire.h"

modif::modif(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::modif)
{
    ui->setupUi(this);
}

modif::~modif()
{
    delete ui;
}



void modif::on_pushButton_clicked()
{
    QString matriculeFiscale = ui->matriculeFiscale_LE->text();
    QString nouveauNomEntreprise = ui->nouveauNomEntreprise_LE->text();
    QString nouvelleAdresse = ui->nouvelleAdresse_LE->text();
    QString nouveauNumeroTelephone = ui->nouveauNumeroTelephone->text();

    // Optional: Retrieve other values if modifying more fields

    // Create a Partenaire object (assuming you have a constructor)
    Partenaire partenaire;

    // Call modifierContrat function based on your needs
    bool success;
    // Modify all fields:
    // success = partenaire.modifierContrat(matriculeFiscale, nouveauNomEntreprise, nouvelleAdresse, nouveauNumeroTelephone, nouveauDebutContrat, nouveauFinContrat);
    // Modify specific fields (replace with actual parameter names if different):
    success = partenaire.modifierContrat(matriculeFiscale, nouveauNomEntreprise, nouvelleAdresse,nouveauNumeroTelephone);

    // Display message based on success
    if (success) {
        QMessageBox::information(this, "Succès", "Modification du contrat réussie !");
    } else {
        QMessageBox::warning(this, "Erreur", "La modification du contrat n'a pas pu être effectuée.");
    }
}

void modif::on_pushButton_3_clicked()
{
    this->close();

}

