<?php


namespace App\Controller\Controller;


use App\Controller\Auth;
use App\Formatter\Paragraph;
use App\Formatter\StringToBoolean;
use App\Http\NotFoundResponse;
use App\Http\Response;
use App\Renderable;
use App\View\FlashMessage;
use App\View\View;
use App\Model;
use App\Controller\Form;

class StaticPageController extends AbstractRestController
{
    public function create(): Renderable
    {
        return new View('static_pages.create', [
            'title' => 'Создать статичную страницу',
            'fields' => $this->getFields(),
        ]);
    }

    public function store(): Renderable
    {
        if (! $this->checkForm(new Form\AddStaticPage())) {
            return Response::redirectBack();
        }

        Model\StaticPage::add(
            htmlentities($_POST['title']),
            isset($_POST['p_teg']) ? (new Paragraph())->format($_POST['text']) : $_POST['text'],
        );

        new FlashMessage(' Успех!', 'Статичная страница добавлена');
        return (Response::redirect(PATH_ADMIN_LIST . '/static_pages'));
    }

    public function show(string $id): Renderable
    {
        $preview = (isset($_GET['preview']) && Auth::getInstance()->isPriorityUser());

        if (! $staticPage = Model\StaticPage::findByIdAndOnlyActive($id, ! $preview)) {
            return new NotFoundResponse();
        }

        return new View('static_pages.show', [
            'title' => $staticPage->title,
            'staticPage' => $staticPage->attributes(),
            'preview' => $preview,
        ]);
    }

    public function edit(string $id): Renderable
    {
        if (! $staticPage = Model\StaticPage::findById($id)) {
            return new NotFoundResponse();
        }

        $attributes = $staticPage->attributes();

        return new View('static_pages.edit', [
            'title' => 'Редактировать статичную страницу',
            'staticPage' => $attributes,
            'fields' => $this->getFields($attributes),
        ]);
    }

    public function update(string $id): Renderable
    {
        /** @var Model\StaticPage $staticPage */
        if (! $staticPage = Model\StaticPage::findById($id)) {
            return Response::redirectBack();
        }

        if (isset($_POST['_active'])) {
            return $this->activate($staticPage);
        }

        if (! $this->checkForm(new Form\EditStaticPage())) {
            return Response::redirectBack();
        }

        $staticPage->update(
            htmlentities($_POST['title']),
            isset($_POST['p_teg']) ? (new Paragraph())->format($_POST['text']) : $_POST['text'],
        );

        new FlashMessage(' Успех!', 'Страница успешно сохранена');
        return (Response::redirect(PATH_ADMIN_LIST . '/static_pages'));
    }

    public function destroy(string $id): Renderable
    {
        if (! $staticPage = Model\StaticPage::findById($id)) {
            return new NotFoundResponse();
        }

        $staticPage->delete();

        new FlashMessage('', 'Страница id ' . $id . ' удалена');
        return Response::redirectBack();
    }

    private function activate(Model\StaticPage $staticPage): Renderable
    {
        $staticPage->setActive($active = (new StringToBoolean())->format($_POST['_active']));

        new FlashMessage('', 'Страница id ' . $staticPage->id . ($active ? ' опубликована' : ' скрыта'));
        return Response::redirectBack();
    }
}