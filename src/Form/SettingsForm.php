<?php

namespace Drupal\uod_custom_css_class_to_body\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\Cache;

/**
 * Configure Custom CSS Class to Body settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'uod_custom_css_class_to_body_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['uod_custom_css_class_to_body.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['body_class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CSS classes'),
      '#default_value' => $this->config('uod_custom_css_class_to_body.settings')->get('body_class'),
      '#description' => $this->t('To add multiple classes, separate them with a space.'),
      '#required' => TRUE,
    ];
    $form['pages'] = [
      '#type' => 'select2',
      '#autocomplete' => TRUE,
      '#title' => $this->t('Pages'),
      '#description' => $this->t('Search and select the pages.'),
      '#target_type' => 'node',
      '#selection_handler' => 'default:node',
      '#selection_settings' => [
        'match_operator' => 'STARTS_WITH',
        'match_limit'    => 10,
        'auto_create'    => FALSE,
        'auto_create_bundle' => '',
        'target_bundles' => ['article', 'page'],
      ],
      '#default_value' => $this->config('uod_custom_css_class_to_body.settings')->get('pages'),
      '#multiple' => TRUE,
      '#required' => TRUE,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $pages_value = $form_state->getValue('pages');
    $pages = array_column($pages_value, 'target_id');
    $old_pages = $this->config('uod_custom_css_class_to_body.settings')->get('pages');
    $invalidate_pages = array_merge($old_pages, $pages);

    // To invalidate the cache of old/new pages.
    foreach ($invalidate_pages as $nid) {
      $tags = ['node:' . $nid];
      Cache::invalidateTags($tags);
    }

    $this->config('uod_custom_css_class_to_body.settings')
      ->set('body_class', $form_state->getValue('body_class'))
      ->set('pages', $pages)
      ->save();
    parent::submitForm($form, $form_state);
  }

}
