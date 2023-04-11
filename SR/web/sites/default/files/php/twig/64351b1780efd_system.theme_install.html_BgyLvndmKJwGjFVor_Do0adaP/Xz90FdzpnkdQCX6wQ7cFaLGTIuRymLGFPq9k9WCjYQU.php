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

/* @help_topics/system.theme_install.html.twig */
class __TwigTemplate_2893845b239a79e10b8aa6709a894c5d extends \Twig\Template
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
        // line 7
        $context["themes_url"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getUrl("system.themes_page"));
        // line 8
        echo "<h2>";
        echo t("Goal", array());
        echo "</h2>
<p>";
        // line 9
        echo t("Install a core theme, or a contributed theme that has already been downloaded. Choose the default themes to use for the site and for administrative pages.", array());
        echo "</p>
<h2>";
        // line 10
        echo t("Steps", array());
        echo "</h2>
<ol>
  <li>";
        // line 12
        echo t("In the <em>Manage</em> administrative menu, navigate to <a href=\"@themes_url\"><em>Appearance</em></a>.", array("@themes_url" => ($context["themes_url"] ?? null), ));
        echo "</li>
  <li>";
        // line 13
        echo t("Locate the themes that you want to use as the site default theme and for administrative pages.", array());
        echo "</li>
  <li>";
        // line 14
        echo t("For each of these themes, if the theme is in the <em>Uninstalled themes</em> section, click the <em>Install</em> link to install the theme. Wait for the theme to be installed (translations might be downloaded). You should be returned to the <em>Appearance</em> page.", array());
        echo "</li>
  <li>";
        // line 15
        echo t("Locate the theme that you want to be your default theme, which should now be in the <em>Installed themes</em> section. If it is not already labeled as the <em>default theme</em>, click the <em>Set as default</em> link.", array());
        echo "</li>
  <li>";
        // line 16
        echo t("At the bottom of the page, select the <em>Administration theme</em> that you want to use on administrative pages. Click <em>Save configuration</em> if you selected a new theme.", array());
        echo "</li>
  <li>";
        // line 17
        echo t("If you changed the default theme for your site, visit the site home page or another page on the non-administration part of your site and verify that the site is using the new theme. If you changed the administration theme, verify that the new theme is used on administrative pages.", array());
        echo "</li>
</ol>";
    }

    public function getTemplateName()
    {
        return "@help_topics/system.theme_install.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 17,  71 => 16,  67 => 15,  63 => 14,  59 => 13,  55 => 12,  50 => 10,  46 => 9,  41 => 8,  39 => 7,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/system.theme_install.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\SR\\web\\core\\modules\\help_topics\\help_topics\\system.theme_install.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 7, "trans" => 8);
        static $filters = array("escape" => 12);
        static $functions = array("render_var" => 7, "url" => 7);

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
