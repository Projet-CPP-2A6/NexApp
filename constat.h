#ifndef CONSTAT_H
#define CONSTAT_H

#include <QString>
#include <QDate>
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

class constat
{
public:
    QString ID;
    QString dateConstat;
    QString lieuConstat;
    QString typeConstat;
    QString description;
    QString signature;

public:
    // Constructeurs
    constat() {}
    constat(QString ID, QString dateConstat, QString lieuConstat, QString typeConstat, QString description, QString signature);

    // Getters
    QString getID() { return ID; }
    QString getDateConstat() { return dateConstat; }
    QString getLieuConstat() { return lieuConstat; }
    QString getTypeConstat() { return typeConstat; }
    QString getDescription() { return description; }
    QString getSignature() { return signature; }

    // Setters
    void setID(QString ID);
    void setDateConstat(QString dateConstat);
    void setLieuConstat(QString lieuConstat);
    void setTypeConstat(QString typeConstat);
    void setDescription(QString description);
    void setSignature(QString signature);
    // cruds

   bool ajouter();
  bool modifierConstat(const QString& ID, const QString& nouvelleDateConstat, const QString& nouveauLieuConstat, const QString& nouvelleSignature);
  bool supprimer(const QString& ID);
  QSqlQueryModel* afficher();
  QSqlQueryModel* TriPar(QString typeConstat);
  QStandardItemModel* recherche(QString str, bool rechercheParID);


};

#endif // CONSTAT_H
