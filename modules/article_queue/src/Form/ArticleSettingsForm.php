<?php

namespace Drupal\article_queue\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ArticleSettingsForm.
 */
class ArticleSettingsForm extends ConfigFormBase
{

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
            'article_queue.articlesettings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'article_settings_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('article_queue.articlesettings');
        $form['site_url'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Site URL'),
            '#description' => $this->t('Enter Connector Site URL'),
            '#maxlength' => 64,
            '#size' => 64,
            '#default_value' => $config->get('site_url'),
        ];
        $form['username'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Username'),
            '#description' => $this->t('Enter Connector Site User Name'),
            '#maxlength' => 64,
            '#size' => 64,
            '#default_value' => $config->get('username'),
        ];
        $form['password'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Password'),
            '#description' => $this->t('Enter Connector Site Password'),
            '#maxlength' => 64,
            '#size' => 64,
            '#default_value' => $config->get('password'),
        ];
        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        parent::submitForm($form, $form_state);

        $this->config('article_queue.articlesettings')
            ->set('site_url', $form_state->getValue('site_url'))
            ->set('username', $form_state->getValue('username'))
            ->set('password', $form_state->getValue('password'))
            ->save();
    }
}
