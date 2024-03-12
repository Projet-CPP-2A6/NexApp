#ifndef SUPPRESSION_H
#define SUPPRESSION_H
#include "partenaire.h"

#include <QDialog>

namespace Ui {
class suppression;
}

class suppression : public QDialog
{
    Q_OBJECT

public:
    explicit suppression(QWidget *parent = nullptr);
    ~suppression();

private slots:
    void on_pushButton_clicked();

private:
    Ui::suppression *ui;
    partenaire p ;
};

#endif // SUPPRESSION_H
