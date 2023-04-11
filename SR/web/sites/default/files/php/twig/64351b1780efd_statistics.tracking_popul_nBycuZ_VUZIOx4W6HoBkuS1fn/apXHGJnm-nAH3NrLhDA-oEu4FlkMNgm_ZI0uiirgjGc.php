<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @help_topics/statistics.tracking_popular_content.html.twig */
class __TwigTemplate_f534d269acce4925c222f26403098780 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 8
        $context["statistics_settings"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getUrl("statistics.settings"));
        // line 9
        $context["permissions"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getUrl("user.admin_permissions"));
        // line 10
        echo "<h2>";
        echo t("Goal", array());
        echo "</h2>
<p>";
        // line 11
        echo t("Configure and display tracking of how many times content has been viewed on your site, assuming that the core Statistics module is currently installed.", array());
        echo "</p>
<h2>";
        // line 12
        echo t("What are the options for displaying popularity tracking?", array());
        echo "</h2>
<p>";
        // line 13
        echo t("You can display a <em>content hits</em> counter of how many times a content item has been viewed, at the bottom of content item pages. You can also place a <em>Popular content</em> block in a region of your theme, which shows a list of the most popular and most recently-viewed content.", array());
        echo "</p>
<h2>";
        // line 14
        echo t("Steps", array());
        echo "</h2>
<ol>
  <li>";
        // line 16
        echo t("In the <em>Manage</em> administrative menu, navigate to <em>Configuration</em> &gt; <em>System</em> &gt; <a href=\"@statistics_settings\"><em>Statistics</em></a>.", array("@statistics_settings" => ($context["statistics_settings"] ?? null), ));
        echo "</li>
  <li>";
        // line 17
        echo t("Check <em>Count content views</em> and click <em>Save configuration</em>.", array());
        echo "</li>
  <li>";
        // line 18
        echo t("In the <em>Manage</em> administrative menu, navigate to <em>People</em> &gt; <a href=\"@permissions\"><em>Permissions</em></a>.", array("@permissions" => ($context["permissions"] ?? null), ));
        echo "</li>
  <li>";
        // line 19
        echo t("In the <em>Statistics</em> section, check or uncheck the <em>View content hits</em> permission for each role. Click <em>Save permissions</em>.", array());
        echo "</li>
  <li>";
        // line 20
        echo t("Optionally, in the <em>Manage</em> administrative menu, navigate to <em>Structure</em> &gt; <em>Block layout</em>. Place the <em>Popular content</em> block in a region in your theme (you will need to have the core Block module installed; see related topic for more details on block placement).", array());
        echo "</li>
</ol>";
    }

    public function getTemplateName()
    {
        return "@help_topics/statistics.tracking_popular_content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  81 => 20,  77 => 19,  73 => 18,  69 => 17,  65 => 16,  60 => 14,  56 => 13,  52 => 12,  48 => 11,  43 => 10,  41 => 9,  39 => 8,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/statistics.tracking_popular_content.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\SR\\web\\core\\modules\\help_topics\\help_topics\\statistics.tracking_popular_content.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 8, "trans" => 10);
        static $filters = array("escape" => 16);
        static $functions = array("render_var" => 8, "url" => 8);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'trans'],
                ['escape'],
                ['render_var', 'url']
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
