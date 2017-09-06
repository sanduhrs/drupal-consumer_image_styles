<?php

namespace Drupal\consumer_image_styles\Plugin\Consumers\Type;

use Drupal\consumers\ConsumerTypeInterface;
use Drupal\consumers\Entity\Consumer;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Plugin\PluginBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * @ConsumerType(
 *   id = "image_style",
 *   label = @Translation("Image style"),
 *   hasSummary = true,
 * )
 */
class ImageStyle extends PluginBase implements ConsumerTypeInterface {

  /**
   * {@inheritdoc}
   */
  public function summary(Consumer $entity) {
    $build = [
      '#theme' => 'item_list', '#items' => [],
    ];
    foreach ($entity->get('image_styles') as $image_style) {
      $build['#items'][] = $image_style->entity->label();
    }
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function storageFields() {
    $fields = [];
    $fields['image_styles'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(new TranslatableMarkup('Image Styles'))
      ->setDescription(new TranslatableMarkup('Image styles this consumer will need. All images will provide all the variants selected here.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'image_style')
      ->setSetting('handler', 'default')
      ->setCardinality(FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED)
      ->setTranslatable(FALSE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'type' => 'entity_reference_label',
        'weight' => 5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_buttons',
        'weight' => 5,
      ]);
    return $fields;
  }


}
