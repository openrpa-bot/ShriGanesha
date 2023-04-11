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

/* @help_topics/system.cache.html.twig */
class __TwigTemplate_f2b759a2058d8414ede51e1fb37bc263 extends \Twig\Template
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
        // line 6
        $context["performance_url"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getUrl("system.performance_settings"));
        // line 7
        echo "<h2>";
        echo t("Goal", array());
        echo "</h2>
<p>";
        // line 8
        echo t("Clear the data in the site cache.", array());
        echo "</p>
<h2>";
        // line 9
        echo t("What is the cache?", array());
        echo "</h2>
<p>";
        // line 10
        echo t("Some of the calculations that are done when your site loads a page take a long time to run. To save time when these calculations would need to be done again, their results can be <em>cached</em> in your site's database. There are internal mechanisms to <em>clear</em> cached data when the conditions or assumptions that went into the calculation have changed, but you can also clear cached data manually. When your site is misbehaving, a good first step is to clear the cache and see if the problem goes away.", array());
        echo "</p>
<h2>";
        // line 11
        echo t("Steps", array());
        echo "</h2>
<ol>
  <li>";
        // line 13
        echo t("In the <em>Manage</em> administrative menu, navigate to <em>Configuration</em> &gt; <em>Development</em> &gt; <em><a href=\"@performance_url\"><em>Performance</em></a></em>.", array("@performance_url" => ($context["performance_url"] ?? null), ));
        echo "</li>
  <li>";
        // line 14
        echo t("Click <em>Clear all caches</em>. Your site's cached data will be cleared.", array());
        echo "</li>
</ol>
<h2>";
        // line 16
        echo t("Additional resources", array());
        echo "</h2>
<ul>
    <li>";
        // line 18
        echo t("<a href=\"https://www.drupal.org/docs/user_guide/en/prevent-cache.html\">Concept: Cache in the User Guide</a>", array());
        echo "</li>
</ul>";
    }

    public function getTemplateName()
    {
        return "@help_topics/system.cache.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 18,  72 => 16,  67 => 14,  63 => 13,  58 => 11,  54 => 10,  50 => 9,  46 => 8,  41 => 7,  39 => 6,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/system.cache.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\SR\\web\\core\\modules\\help_topics\\help_topics\\system.cache.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 6, "trans" => 7);
        static $filters = array("escape" => 13);
        static $functions = array("render_var" => 6, "url" => 6);

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
