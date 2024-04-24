#ifndef AJOUCH_H
#define AJOUCH_H

#include <QDialog>

namespace Ui {
class ajouch;
}

class ajouch : public QDialog
{
    Q_OBJECT

public:
    explicit ajouch(QWidget *parent = nullptr);
    ~ajouch();

private slots:
    void on_pushButton_clicked();

private:
    Ui::ajouch *ui;
};

#endif // AJOUCH_H
