<?php

namespace NewsSite\Controllers;

class NewsController extends AbstractController
{
    public function newsAction()
    {
        /** @var \NewsSite\Models\News $news */
        $news = $this->container->get('model.news');

        $listOfNews = $news->getNews();

        $templateVariables = ['news' => $listOfNews];
        $template = 'news.view.php';

        return $this->render($template, $templateVariables);
    }

    public function singleNewsAction($id) {
        /** @var \NewsSite\Models\News $news */
        $news = $this->container->get('model.singleNew');

        $listOfNews = $news->getSingleNew($id);

        $templateVariables = ['news' => $listOfNews];
        $template = 'single.news.view.php';

        return $this->render($template, $templateVariables);
    }
}
