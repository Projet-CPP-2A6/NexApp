#ifndef MODIFCH_H
#define MODIFCH_H

#include <QDialog>

namespace Ui {
class modifch;
}

class modifch : public QDialog
{
    Q_OBJECT

public:
    explicit modifch(QWidget *parent = nullptr);
    ~modifch();

private slots:
    void on_pushButton_clicked();

private:
    Ui::modifch *ui;
};

#endif // MODIFCH_H
