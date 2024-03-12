
#ifndef PARTENAIRE_H
#define PARTENAIRE_H
#include <QString>
#include <QSqlQueryModel>
#include <QTableView>
#include <QString>
#include <QSqlQuery>
#include <QSqlQueryModel>
#include <QDoubleValidator>
#include <QDateTime>
#include <QStandardItemModel>

#include <QSqlDatabase>



class partenaire
{
    QString matriculeFiscale;
    QString nomEntreprise;
    QString adresse;
    QString numeroTelephone;
    QString dureeContrat;
    QString secteurActivite;
    QString interet;

public:
    // Constructeurs
    partenaire() {}

    partenaire( QString matriculeFiscale , QString nomEntreprise, QString adresse, QString numeroTelephone, QString dureeContrat, QString secteurActivite, QString interet);

    // Getters

    QString getMatriculeFiscale() { return matriculeFiscale; }
    QString getNomEntreprise() { return nomEntreprise; }
    QString getAdresse() { return adresse; }
    QString getNumeroTelephone() { return numeroTelephone; }
    QString getDureeContrat() { return dureeContrat; }
    QString getSecteurActivite() { return secteurActivite; }
    QString getInteret() { return interet; }

    // Setters
    void setMatriculeFiscale(QString matriculeFiscale);
    void setNomEntreprise(QString nomEntreprise);
    void setAdresse(QString adresse);
    void setNumeroTelephone(QString numeroTelephone);
    void setDureeContrat(QString dureeContrat);
    void setSecteurActivite(QString secteurActivite);
    void setInteret(QString interet);

    // CRUD methods
    bool ajouter();
    QSqlQueryModel* afficher();
    bool modifiercontrat(const QString& dureeContrat, const QString& nouveaudureeContrat);


    bool supprimer(const QString& matriculeFiscale);
    QStandardItemModel* recherche_MATRICULE_FISCALE(QString str);
     QSqlQueryModel *TriPar(QString dureeContrat);

};

#endif // PARTENAIRE_H
