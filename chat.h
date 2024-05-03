#ifndef CHAT_H
#define CHAT_H

#include <QDialog>

namespace Ui {
class chat;
}

class chat : public QDialog
{
    Q_OBJECT

public:
    explicit chat(QWidget *parent = nullptr);
    ~chat();
    QString generateResponse(QString userInput);
     void afficherHistoriqueQuestions();



private slots:
    void on_pushButton_clicked();

    void on_pushButton_3_clicked();

private:
    Ui::chat *ui;
    QList<QString> userQuestions;
};

#endif // CHAT_H
