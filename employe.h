#ifndef EMPLOYE_H
#define EMPLOYE_H

#include <QDate>
#include <QString>
#include <QStandardItemModel>
#include <QtSql>



class Employe
{
    int CIN = 0;
    QDate DATE_EMB;
    int NUM_TEL = 0;
    QString NOM;
    QString PRENOM;
    QString EMAIL_EMP;
    QString FONCTION;
    int SALAIRE = 0;

public:
    Employe();

    int getCIN();
    QDate getDATE_EMB();
    int getNUM_TEL();
    QString getNOM();
    QString getPRENOM();
    QString getEMAIL_EMP();
    QString getFONCTION();
    int getSALAIRE();

    void setCIN(int nvCIN);
    void setDATE_EMB(QDate nvDATE_EMB);
    void setNOM(QString nvNOM);
    void setPRENOM(QString nvPRENOM);
    void setEMAIL_EMP(QString nvEMAIL_EMP);
    void setFONCTION(QString nvFONCTION);
    void setSALAIRE(int nvSALAIRE);

    bool AjouterEmploye(int cinnv,QDate nvde,int nvnumero,QString nvnom, QString nvprenom , QString nvemail, QString nvfonction,int nvsalaire );
    QStandardItemModel* afficher();
    bool EffacerEmploye(int n);
    bool Modifier_element(int cinnv,QDate nvde,int nvnumero,QString nvnom, QString nvprenom , QString nvemail, QString nvfonction,int nvsalaire );

     QStandardItemModel* recherche_cin(QString str);
};

#endif // EMPLOYE_H
