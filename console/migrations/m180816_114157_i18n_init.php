<?php

use yii\db\Migration;

/**
 * Class m180816_114157_i18n_init
 */
class m180816_114157_i18n_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%source_message}}', ['id', 'category', 'message'], [
            [1, 'app', 'Bid'],
            [2, 'app', 'Bids'],
            [3, 'app', 'Manager'],
            [4, 'app', 'Managers'],
            [5, 'app', 'Review'],
            [6, 'app', 'Reviews'],
            [7, 'app', 'Notification'],
            [8, 'app', 'Notifications'],
            [9, 'app', 'Profile'],
            [10, 'app', 'User Profile'],
            [11, 'app', 'User'],
            [12, 'app', 'Users'],
            [13, 'app', 'Home'],
            [14, 'app', 'Create'],
            [15, 'app', 'Update'],
            [16, 'app', 'General'],
            [17, 'app', 'Name'],
            [18, 'app', 'First Name'],
            [19, 'app', 'Last Name'],
            [20, 'app', 'Full Name'],
            [21, 'app', 'Password'],
            [22, 'app', 'Current Password'],
            [23, 'app', 'Repeat Password'],
            [24, 'app', 'Created At'],
            [25, 'app', 'Updated At'],
            [26, 'app', 'Status'],
            [27, 'app', 'Processed'],
            [28, 'app', 'Processed By'],
            [29, 'app', 'Created By'],
            [30, 'app', 'Phone Number'],
            [31, 'app', 'Time'],
            [32, 'app', 'Recipient'],
            [33, 'app', 'Text'],
            [34, 'app', 'Dashboard'],
            [35, 'app', 'Welcome'],
            [36, 'app', 'Management'],
            [37, 'app', 'View all'],
            [38, 'app', 'Incorrect email or password.'],
            [39, 'app', 'Payment System'],
            [40, 'app', 'Wallet'],
            [41, 'app', 'Wallet Number'],
            [42, 'app', 'Client First Name'],
            [43, 'app', 'Client Last Name'],
            [44, 'app', 'Where Did The Money Come From'],
            [45, 'app', 'Need To Transfer Money Here'],
            [46, 'app', 'Amount From Customer'],
            [47, 'app', 'Amount To Be Transferred'],
            [48, 'app', 'Follow the link below to confirm your E-mail.'],
            [49, 'app', 'Password updated successfully.'],
            [50, 'app', 'Something wrong, please try again later.'],
            [51, 'app', 'Bid was successfully updated.'],
            [52, 'app', 'Status was updated.'],
            [53, 'app', 'Invitation link expired.'],
            [54, 'app', 'Notification was successfully deleted.'],
            [55, 'app', 'A link has been sent to your mail. To pass the verification procedure, check your mail.'],
            [56, 'app', 'Profile successfully updated.'],
            [57, 'app', 'An error occurred while loading the image.'],
            [58, 'app', 'Image successfully uploaded.'],
            [59, 'app', 'Password was successfully updated.'],
            [60, 'app', 'User is not found.'],
            [61, 'app', 'E-mail successfully updated.'],
            [62, 'app', 'You do not have permission to view this page. Check your credentials.'],
            [63, 'app', 'Are you sure you want to delete the selected items?'],
            [64, 'app', 'Thank you for signup.'],
            [65, 'app', 'Type'],
            [66, 'app', 'Role Name'],
            [67, 'app', 'Male'],
            [68, 'app', 'Female'],
            [69, 'app', 'Username'],
            [70, 'app', 'Role'],
            [71, 'app', 'Country'],
            [72, 'app', 'City'],
            [73, 'app', 'Avatar'],
            [74, 'app', 'No'],
            [75, 'app', 'Yes'],
            [76, 'app', 'Description'],
            [77, 'app', 'Settings'],
            [78, 'app', 'Delete'],
            [79, 'app', 'Save'],
            [80, 'app', 'Contact Us'],
            [81, 'app', 'Submit'],
            [82, 'app', 'About Us'],
            [83, 'app', 'User Report'],
            [84, 'app', 'There are notifications'],
            [85, 'app', 'See All Alerts'],
            [86, 'app', 'Log Out'],
            [87, 'app', 'Remember me'],
            [88, 'app', 'Login'],
            [89, 'app', 'Read'],
            [90, 'app', 'Unread'],
            [91, 'app', 'Admin Panel'],
            [92, 'app', 'Paid'],
            [93, 'app', 'Accepted'],
            [94, 'app', 'In progress'],
            [95, 'app', 'Done'],
            [96, 'app', 'Rejected'],
            [97, 'app', 'List'],
            [98, 'app', 'Bids History'],
            [99, 'app', 'Active'],
            [100, 'app', 'Inactive'],
            [101, 'app', 'Invite new manager'],
            [102, 'app', 'Invite Code Status'],
            [103, 'app', 'New'],
            [104, 'app', 'Enter your e-mail address'],
            [105, 'app', 'Enter your password'],
            [106, 'app', 'Incorrect email or password.'],
            [107, 'app', 'Log Out'],
            [108, 'app', 'Are you sure?'],
            [109, 'app', 'Re-invite'],
            [110, 'app', 'New manager creation form'],
            [111, 'app', 'Password Again'],
            [112, 'app', 'Reset'],
            [113, 'app', 'Sum'],
            [114, 'app', 'Bid Status'],
            [115, 'app', 'View'],
            [116, 'app', 'Paid by client'],
            [117, 'app', 'Paid by us'],
            [118, 'app', 'Reserve'],
            [119, 'app', 'Reserves'],
            [120, 'app', 'Currency'],
            [121, 'app', 'Bid successfully deleted.'],
            [122, 'app', 'Bid successfully updated.'],
            [123, 'app', 'Status successfully updated.'],
            [124, 'app', 'Notification successfully deleted.'],
            [125, 'app', 'Reserve successfully updated.'],
            [126, 'app', 'Invalid old password.'],
            [127, 'app', 'This email address has already been taken.'],
            [128, 'app', 'This phone number has already been taken.'],
            [129, 'app', 'Password Confirm'],
            [130, 'app', 'Edit'],
            [131, 'app', 'Message was successfully send.'],
            [132, 'app', 'A new user has been registered. Registration was conducted with a phone number {phone_number}.'],
            [133, 'app', 'User {full_name} has created new bid. Transfer to the card {sum} {currency} through the Wallet app. Recipient:Card/account {wallet}.'],
            [134, 'app', 'Client {full_name} has paid {sum} {currency} to wallet {wallet} .'],
            [135, 'app', 'Your bid number {bid_id} is now in progress.'],
            [136, 'app', 'Your bid is rejected. Transfer to the card {sum} {currency} through the Wallet app. Recipient: Card/account {wallet}.'],
            [137, 'app', 'Close'],
            [138, 'app', 'Creation password'],
            [139, 'app', 'Status Online'],
            [140, 'app', 'Last Login'],
            [141, 'app', 'Manager successfully deleted.'],
            [142, 'app', 'Manager successfully created.'],
            [143, 'app', 'Invite Manager'],
            [144, 'app', 'Accept Invite'],
            [145, 'app', 'Server error occurred while updating profile'],
            [146, 'app', 'Source'],
            [147, 'app', 'Read all'],
            [148, 'app', 'Delete all'],
            [149, 'app', 'Change Status'],
            [150, 'app', 'Select status'],
            [151, 'app', 'Bid Closed'],
            [152, 'app', 'Logs'],
            [153, 'app', 'Reset Grid'],
            [154, 'app', 'In Progress By Manager'],
            [155, 'app', 'Visible'],
            [156, 'app', 'Invisible'],
        ]);

        $this->batchInsert('{{%message}}', ['id', 'language', 'translation'], [
            [1, 'ru', 'Заявка'],
            [2, 'ru', 'Заявки'],
            [3, 'ru', 'Менеджер'],
            [4, 'ru', 'Менеджеры'],
            [5, 'ru', 'Отзыв'],
            [6, 'ru', 'Отзывы'],
            [7, 'ru', 'Уведомление'],
            [8, 'ru', 'Уведомления'],
            [9, 'ru', 'Профиль'],
            [10, 'ru', 'Профиль Пользователя'],
            [11, 'ru', 'Пользователь'],
            [12, 'ru', 'Пользователи'],
            [13, 'ru', 'Домой'],
            [14, 'ru', 'Создать'],
            [15, 'ru', 'Обновить'],
            [16, 'ru', 'Основное'],
            [17, 'ru', 'Название'],
            [18, 'ru', 'Имя'],
            [19, 'ru', 'Фамилия'],
            [20, 'ru', 'Полное Имя'],
            [21, 'ru', 'Пароль'],
            [22, 'ru', 'Текущий Пароль'],
            [23, 'ru', 'Повторите Пароль'],
            [24, 'ru', 'Дата Создания'],
            [25, 'ru', 'Дата Обновления'],
            [26, 'ru', 'Статус'],
            [27, 'ru', 'Обработана'],
            [28, 'ru', 'Кем Обработана'],
            [29, 'ru', 'Автор'],
            [30, 'ru', 'Номер Телефона'],
            [31, 'ru', 'Время'],
            [32, 'ru', 'Получатель'],
            [33, 'ru', 'Текст'],
            [34, 'ru', 'Панель управления'],
            [35, 'ru', 'Добро пожаловать'],
            [36, 'ru', 'Менеджмент'],
            [37, 'ru', 'Посмотреть все'],
            [38, 'ru', 'Неверный E-mail или пароль.'],
            [39, 'ru', 'Платежная система'],
            [40, 'ru', 'Кошелек'],
            [41, 'ru', 'Номер Кошелека'],
            [42, 'ru', 'Имя Клиента'],
            [43, 'ru', 'Фамилия Клиента'],
            [44, 'ru', 'Откуда Пришли Деньги'],
            [45, 'ru', 'Нужно Перевести Деньги Сюда'],
            [46, 'ru', 'Сумма От Клиента'],
            [47, 'ru', 'Нужно Перевести'],
            [48, 'ru', 'Пройдите по ссылке, чтобы подтвердить свой адресс жлектроной почты.'],
            [49, 'ru', 'Пароль успешно изменён.'],
            [50, 'ru', 'Что-то пошло не так, повторите попытку позже.'],
            [51, 'ru', 'Заявка успешно изменена.'],
            [52, 'ru', 'Статус успешно изменён.'],
            [53, 'ru', 'Приглашение истекло.'],
            [54, 'ru', 'Уведомление успешно удалено.'],
            [55, 'ru', 'Ссылка отправлена на Вашу почту. Чтобы пройти процедуру верификации, проверьте Вашу почту.'],
            [56, 'ru', 'Профиль успешно обновлен.'],
            [57, 'ru', 'Ошибка при загрузке картинки.'],
            [58, 'ru', 'Картинка успешно загружена.'],
            [59, 'ru', 'Пароль успешно обновлен.'],
            [60, 'ru', 'Пользователь не найден.'],
            [61, 'ru', 'E-mail успешно обновлен.'],
            [62, 'ru', 'У вас нет разрешения на просмотр этой страницы. Проверьте свои учетные данные.'],
            [63, 'ru', 'Вы уверены, что хотите удалить выбранные элементы?'],
            [64, 'ru', 'Благодарим Вас за регистрацию.'],
            [65, 'ru', 'Тип'],
            [66, 'ru', 'Название Роли'],
            [67, 'ru', 'Мужской'],
            [68, 'ru', 'Женский'],
            [69, 'ru', 'Имя пользователя'],
            [70, 'ru', 'Роль'],
            [71, 'ru', 'Страна'],
            [72, 'ru', 'Город'],
            [73, 'ru', 'Аватар'],
            [74, 'ru', 'Нет'],
            [75, 'ru', 'Да'],
            [76, 'ru', 'Описание'],
            [77, 'ru', 'Настройки'],
            [78, 'ru', 'Удалить'],
            [79, 'ru', 'Сохранить'],
            [80, 'ru', 'Связитесь с нами'],
            [81, 'ru', 'Отправить'],
            [82, 'ru', 'О нас'],
            [83, 'ru', 'Отчет Пользователя'],
            [84, 'ru', 'Есть уведомления'],
            [85, 'ru', 'Посмотреть все уведомления'],
            [86, 'ru', 'Выйти'],
            [87, 'ru', 'Запоминить меня'],
            [88, 'ru', 'Войти'],
            [89, 'ru', 'Прочитано'],
            [90, 'ru', 'Непрочитано'],
            [91, 'ru', 'Панель<br>Администратора'],
            [92, 'ru', 'Оплачено'],
            [93, 'ru', 'Принято'],
            [94, 'ru', 'В обработке'],
            [95, 'ru', 'Выполнено'],
            [96, 'ru', 'Отклонено'],
            [97, 'ru', 'Список'],
            [98, 'ru', 'Заявки История'],
            [99, 'ru', 'Активный'],
            [100, 'ru', 'Не активный'],
            [101, 'ru', 'Пригласить нового менеджера'],
            [102, 'ru', 'Статус Кода Инвайта'],
            [103, 'ru', 'Новое'],
            [104, 'ru', 'Введите ваш адрес электронной почты'],
            [105, 'ru', 'Введите ваш пароль'],
            [106, 'ru', 'Неверный адрес электронной почты или пароль.'],
            [107, 'ru', 'Выйти'],
            [108, 'ru', 'Вы уверены?'],
            [109, 'ru', 'Вновь пригласить'],
            [110, 'ru', 'Форма создания нового менеджера'],
            [111, 'ru', 'Пароль Ещё Раз'],
            [112, 'ru', 'Сбросить'],
            [113, 'ru', 'Сумма'],
            [114, 'ru', 'Статус Заявки'],
            [115, 'ru', 'Просмотр'],
            [116, 'ru', 'Оплачено клиентом'],
            [117, 'ru', 'Оплачено нами'],
            [118, 'ru', 'Резерв'],
            [119, 'ru', 'Резервы'],
            [120, 'ru', 'Валюта'],
            [121, 'ru', 'Заявка успешно удалена.'],
            [122, 'ru', 'Заявка успешно обновлена.'],
            [123, 'ru', 'Статус успешно обновлен.'],
            [124, 'ru', 'Уведомление успешно удалено.'],
            [125, 'ru', 'Резервы успешно обновлены.'],
            [126, 'ru', 'Неверно введён старый пароль.'],
            [127, 'ru', 'Этот адрес электронной почты уже занят.'],
            [128, 'ru', 'Этот номер телефона уже занят.'],
            [129, 'ru', 'Подтвердите пароль'],
            [130, 'ru', 'Редактировать'],
            [131, 'ru', 'Сообщение успешно отправлено.'],
            [132, 'ru', 'Зарегистрирован новый пользователь. Регистрация проводилась с номером телефона {phone_number}.'],
            [133, 'ru', 'Пользователь {full_name} создал новую заявку Перевод на карту {sum} {currency} через приложение Wallet. Получатель: Карта/счет {wallet}.'],
            [134, 'ru', 'Клиент {full_name} произвел пдатеж на сумму {sum} {currency} в {wallet} .'],
            [135, 'ru', 'Ваша заявка {bid_id} в обработке.'],
            [136, 'ru', 'Ваша заявка не выполнена. Перевод на карту {sum} {currency} через приложение Wallet. Получатель: Карта/счет {wallet}.'],
            [137, 'ru', 'Закрыть'],
            [138, 'ru', 'Создание пароля'],
            [139, 'ru', 'Статус Онлайн'],
            [140, 'ru', 'Последний Вход'],
            [141, 'ru', 'Менеджер успешно удалён.'],
            [142, 'ru', 'Менеджер успешно создан.'],
            [143, 'ru', 'Пригласить Менеджера'],
            [144, 'ru', 'Инвайт Принят'],
            [145, 'ru', 'Произошла ошибка на сервере при обновлении профиля'],
            [146, 'ru', 'Источник'],
            [147, 'ru', 'Прочитать все'],
            [148, 'ru', 'Удалить все'],
            [149, 'ru', 'Изменить Статус'],
            [150, 'ru', 'Выбрать статус'],
            [151, 'ru', 'Заявка Закрыта '],
            [152, 'ru', 'Логи'],
            [153, 'ru', 'Сбросить таблицу'],
            [154, 'ru', 'Обрабатывается Менеджером'],
            [155, 'ru', 'Видимое'],
            [156, 'ru', 'Невидимое'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%message}}');
        $this->truncateTable('{{%source_message}}');
    }
}
