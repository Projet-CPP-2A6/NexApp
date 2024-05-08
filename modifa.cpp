#include "modifa.h"
#include "ui_modifa.h"
#include <QMessageBox>
#include "aminee.h"
#include "constat.h"



modifa::modifa(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::modifa)
{
    ui->setupUi(this);
}

modifa::~modifa()
{
    delete ui;
}

void modifa::on_pushButton_clicked()
{
    QString ID = ui->lineEdit_ID->text();
    QString nouvelleDateConstat = ui->lineEdit_nouvelleDateConstat->text();
    QString nouveauLieuConstat = ui->lineEdit_nouveauLieuConstat->text();
    QString nouvelleSignature = ui->lineEdit_nouvelleSignature->text();

    // Créer un objet constat
    constat monConstat;

    // Appeler la fonction modifierConstat
    bool success = monConstat.modifierConstat(ID, nouvelleDateConstat, nouveauLieuConstat, nouvelleSignature);

    // Afficher un message en fonction du succès de l'opération
    if (success) {
        QMessageBox::information(this, "Succès", "Modification du constat réussie !");
    } else {
        QMessageBox::warning(this, "Erreur", "La modification du constat n'a pas pu être effectuée.");
    }

}

