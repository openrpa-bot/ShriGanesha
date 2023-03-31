<?php

namespace Drupal\commerce_product\ContextProvider;

use Drupal\commerce_product\Entity\ProductInterface;
use Drupal\commerce_product\Entity\ProductVariationInterface;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Entity\Display\EntityDisplayInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextProviderInterface;
use Drupal\Core\Plugin\Context\EntityContext;
use Drupal\Core\Plugin\Context\EntityContextDefinition;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\layout_builder\DefaultsSectionStorageInterface;
use Drupal\layout_builder\Entity\SampleEntityGeneratorInterface;
use Drupal\layout_builder\OverridesSectionStorageInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Provides a product variation context.
 */
class ProductVariationContext implements ContextProviderInterface {

  use StringTranslationTrait;

  /**
   * The sample entity generator.
   *
   * @var \Drupal\layout_builder\Entity\SampleEntityGeneratorInterface|null
   */
  protected $sampleEntityGenerator;

  /**
   * Constructs a new ProductVariationContext object.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $routeMatch
   *   The route match.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
   *   The request stack.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entityTypeBundleInfo
   *   The entity type bundle info.
   */
  public function __construct(protected RouteMatchInterface $routeMatch, protected EntityTypeManagerInterface $entityTypeManager, protected RequestStack $requestStack, protected EntityTypeBundleInfoInterface $entityTypeBundleInfo) {}

  /**
   * Set the sample entity generator.
   *
   * @param \Drupal\layout_builder\Entity\SampleEntityGeneratorInterface $sample_entity_generator
   *   The sample entity generator.
   */
  public function setSampleEntityGenerator(SampleEntityGeneratorInterface $sample_entity_generator) {
    $this->sampleEntityGenerator = $sample_entity_generator;
  }

  /**
   * {@inheritdoc}
   */
  public function getRuntimeContexts(array $unqualified_context_ids) {
    $context_definition = new EntityContextDefinition('entity:commerce_product_variation', new TranslatableMarkup('Product variation'));
    $value = $this->routeMatch->getParameter('commerce_product_variation');
    $cacheability = new CacheableMetadata();
    $cacheability->setCacheContexts(['route']);
    if ($value instanceof ProductVariationInterface) {
      $context = new Context($context_definition, $value);
      $context->addCacheableDependency($cacheability);
      return ['commerce_product_variation' => $context];
    }

    /** @var \Drupal\commerce_product\ProductVariationStorageInterface $product_variation_storage */
    $product_variation_storage = $this->entityTypeManager->getStorage('commerce_product_variation');
    $product_type_storage = $this->entityTypeManager->getStorage('commerce_product_type');
    $product = $this->routeMatch->getParameter('commerce_product');
    if ($product instanceof ProductInterface) {
      $value = $product_variation_storage->loadFromContext($product);
      $bundle = $product->bundle();
    }
    // @todo Simplify this logic once EntityTargetInterface is available
    // @see https://www.drupal.org/project/drupal/issues/3054490
    elseif (str_contains((string) $this->routeMatch->getRouteName(), 'layout_builder')) {
      /** @var \Drupal\layout_builder\SectionStorageInterface $section_storage */
      $section_storage = $this->routeMatch->getParameter('section_storage');
      if ($section_storage instanceof DefaultsSectionStorageInterface) {
        $context = $section_storage->getContextValue('display');
        assert($context instanceof EntityDisplayInterface);
        if ($context->getTargetEntityTypeId() === 'commerce_product') {
          $bundle = $context->getTargetBundle();
        }
      }
      elseif ($section_storage instanceof OverridesSectionStorageInterface) {
        $context = $section_storage->getContextValue('entity');
        if ($context instanceof ProductInterface) {
          $value = $context->getDefaultVariation();
          $bundle = $context->bundle();
        }
        else {
          $product_from_request = $this->requestStack->getMasterRequest()
            ?->get('commerce_product_context');
          if ($product_from_request instanceof ProductInterface) {
            $value = $product_from_request->getDefaultVariation();
            $bundle = $product_from_request->bundle();
          }
        }
      }
    }
    else {
      $product_from_request = $this->requestStack->getMasterRequest()
        ?->get('commerce_product_context');
      if ($product_from_request instanceof ProductInterface) {
        $value = $product_from_request->getDefaultVariation();
        $bundle = $product_from_request->bundle();
      }
    }

    // For the existing bundle load list of the variation types related to it,
    // in another case get all variation types.
    if (isset($bundle)) {
      /** @var \Drupal\commerce_product\Entity\ProductTypeInterface $product_type */
      $product_type = $product_type_storage->load($bundle);
      $variation_types = $product_type->getVariationTypeIds();
    }
    else {
      $variation_types = array_keys($this->entityTypeBundleInfo->getBundleInfo('commerce_product_variation'));
    }

    // For empty $value create the dummy one.
    if ($value === NULL) {
      if ($this->sampleEntityGenerator !== NULL) {
        $value = $this->sampleEntityGenerator->get('commerce_product_variation', reset($variation_types));
      }
      else {
        $value = $product_variation_storage->create([
          'type' => reset($variation_types),
        ]);
      }
    }

    $cacheability = new CacheableMetadata();
    $cacheability->setCacheContexts(['route']);
    $context = new Context($context_definition, $value);
    $context->addCacheableDependency($cacheability);

    return ['commerce_product_variation' => $context];
  }

  /**
   * {@inheritdoc}
   */
  public function getAvailableContexts() {
    // @todo Remove this route name check once Layout Builder is fixed.
    if ($this->routeMatch->getRouteName() !== NULL) {
      // This handles when the context is called via getAvailableContexts in
      // the entity param converter while route negotiation is being handled.
      //
      // This is a pretty big hack to workaround the fact Layout Builder does
      // not properly invoke getRuntimeContexts but assumes getAvailableContexts
      // will have populated values in the contexts returned.
      //
      // @see https://www.drupal.org/project/drupal/issues/3099968
      // @see \Drupal\Core\ParamConverter\EntityConverter::convert
      return $this->getRuntimeContexts([]);
    }
    $context = EntityContext::fromEntityTypeId(
      'commerce_product_variation',
      $this->t('Product variation from current product.')
    );
    return ['commerce_product_variation' => $context];
  }

}
