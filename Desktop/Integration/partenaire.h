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


class Partenaire
{
public:
    QString matriculeFiscale;
    QString nomEntreprise;
    QString adresse;
    QString numeroTelephone;
    QString secteurActivite;
    QString interet;
    QDate debutContrat; // Nouvel attribut début_contrat de type QDate
    QDate finContrat;   // Nouvel attribut fin_contrat de type QDate

public:
    // Constructeurs
    Partenaire() {}
    Partenaire(QString matriculeFiscale, QString nomEntreprise, QString adresse, QString numeroTelephone, QDate debutContrat, QDate finContrat, QString secteurActivite, QString interet, QString cheminImage);

    // Getters
    QString getMatriculeFiscale() { return matriculeFiscale; }
    QString getNomEntreprise() { return nomEntreprise; }
    QString getAdresse() { return adresse; }
    QString getNumeroTelephone() { return numeroTelephone; }
    QDate getDebutContrat() { return debutContrat; }
    QDate getFinContrat() { return finContrat; }
    QString getSecteurActivite() { return secteurActivite; }
    QString getInteret() { return interet; }
    QString getCheminImage() { return cheminImage; }

    // Setters
    void setMatriculeFiscale(QString matriculeFiscale);
    void setNomEntreprise(QString nomEntreprise);
    void setAdresse(QString adresse);
    void setNumeroTelephone(QString numeroTelephone);
    void setDebutContrat(QDate debutContrat);
    void setFinContrat(QDate finContrat);
    void setSecteurActivite(QString secteurActivite);
    void setInteret(QString interet);
    void setCheminImage(QString cheminImage);
    // CRUD methods
    bool ajouter();
    bool supprimer(const QString& matriculeFiscale);
    QSqlQueryModel* afficher();
    bool modifierContrat(const QString& matriculeFiscale, const QString& nouveauNomEntreprise, const QString& nouvelleAdresse,const QString& nouveauNumeroTelephone);
    QSqlQueryModel *TriPar(QString nomEntreprise);
    /*QStandardItemModel* recherche_MATRICULE_FISCALE(QString str);*/
     QStandardItemModel* recherche(QString str, bool rechercheParMatricule);
    QString cheminImage;
};


#endif // PARTENAIRE_H
