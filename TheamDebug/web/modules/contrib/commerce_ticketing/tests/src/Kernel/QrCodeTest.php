<?php

namespace Drupal\Tests\commerce_ticketing\Kernel;

use Drupal\commerce_ticketing\Entity\CommerceTicket;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

/**
 * Tests the QR Code generation.
 *
 * @group commerce_ticketing
 */
class QrCodeTest extends TicketKernelTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'color',
  ];

  /**
   * Test QR Code.
   */
  public function testQrCode() {
    $this->addPayment();
    $tickets = CommerceTicket::loadMultiple();
    $ticket = reset($tickets);

    $this->container->get('cache.render')->deleteAll();
    $renderer = $this->container->get('renderer');
    $builder = $this->container->get('entity_type.manager')->getViewBuilder('commerce_ticket');
    $output = $builder->view($ticket, 'qr_only_test');

    $label_text = $builder->view($ticket, 'qr_code_label');
    $label_text = trim(preg_replace("/(BSR_ANYCRLF)\R/", '', strip_tags(\Drupal::service('renderer')->renderPlain($label_text))));
    $result = Builder::create()
      ->writer(new PngWriter())
      ->writerOptions([])
      ->data($ticket->uuid())
      ->encoding(new Encoding('UTF-8'))
      ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
      ->size(250)
      ->margin(10)
      ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
      ->labelText($label_text)
      ->labelFont(new NotoSans(20))
      ->labelAlignment(new LabelAlignmentCenter())
      ->backgroundColor($this->hextoColor('#FFFFFF'))
      ->foregroundColor($this->hextoColor('#000000'))
      ->labelTextColor($this->hextoColor('#000000'))
      ->build();

    $element = [
      '#theme' => 'image',
      '#uri' => $result->getDataUri(),
    ];


    $expected = [];
    $expected[] = '';
    $expected[] = '  <div>';
    $expected[] = '    <div>QR Code</div>';
    $expected[] = '              <div>' . $renderer->renderRoot($element) . '</div>';
    $expected[] = '          </div>';
    $expected[] = '';
    $expected_output = implode("\n", $expected);

    $this->assertEquals($expected_output, $renderer->renderRoot($output));
  }

  /**
   * Converts hexadecimal to a QR code color object.
   *
   * @param string $hex
   *   Hex code.
   *
   * @return \Endroid\QrCode\Color\ColorInterface
   *   Color object.
   */
  protected function hextoColor($hex) {
    [$r, $g, $b] = _color_unpack($hex);
    return new Color($r, $g, $b);
  }

}
