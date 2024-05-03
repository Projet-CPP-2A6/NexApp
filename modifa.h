#ifndef MODIFA_H
#define MODIFA_H

#include <QDialog>

namespace Ui {
class modifa;
}

class modifa : public QDialog
{
    Q_OBJECT

public:
    explicit modifa(QWidget *parent = nullptr);
    ~modifa();

private slots:
    void on_pushButton_clicked();

private:
    Ui::modifa *ui;
};

#endif // MODIFA_H
