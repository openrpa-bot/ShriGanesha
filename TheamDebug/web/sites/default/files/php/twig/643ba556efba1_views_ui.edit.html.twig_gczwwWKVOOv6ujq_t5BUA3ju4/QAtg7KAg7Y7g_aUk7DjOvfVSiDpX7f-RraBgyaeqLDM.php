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

/* @help_topics/views_ui.edit.html.twig */
class __TwigTemplate_1d785b4ac5009ab0f6b4949c73fc5e14 extends \Twig\Template
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
        $context["views"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getUrl("entity.view.collection"));
        // line 8
        $context["views_overview_topic"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getTopicLink("views.overview"));
        // line 9
        echo "<h2>";
        echo t("Goal", array());
        echo "</h2>
<p>";
        // line 10
        echo t("Edit an existing view display, to modify what data is displayed or how it is displayed.", array());
        echo "</p>
<h2>";
        // line 11
        echo t("Steps", array());
        echo "</h2>
<ol>
  <li>";
        // line 13
        echo t("If you are not already editing your view, in the <em>Manage</em> administrative menu, navigate to <em>Structure</em> &gt; <a href=\"@views\"><em>Views</em></a>. Find the view you want to edit, and click its <em>Edit</em> link.", array("@views" => ($context["views"] ?? null), ));
        echo "</li>
  <li>";
        // line 14
        echo t("Under <em>Displays</em>, click the display you want to edit.", array());
        echo "</li>
  <li>";
        // line 15
        echo t("Find the section whose settings you want to change, such as <em>Format</em> or <em>Filter criteria</em>. (See @views_overview_topic for more information.)", array("@views_overview_topic" => ($context["views_overview_topic"] ?? null), ));
        echo "</li>
  <li>";
        // line 16
        echo t("For sections containing lists (such as <em>Fields</em> and <em>Filter criteria</em>), to modify or delete an existing item, click the name of the item. To add a new item, click <em>Add</em> in the drop-down list. To change the order of items, click <em>Rearrange</em> in the drop-down list.", array());
        echo "</li>
  <li>";
        // line 17
        echo t("For sections containing individual settings (such as <em>Title</em> and <em>Format</em>), there are often two links for each setting. The first link shows the current value; click that link to change the value. If there is a second link called <em>Settings</em>, click that link to change the settings details. For example, if your <em>Format</em> is currently shown as <em>Unformatted list</em>, click <em>Unformatted list</em> to switch to using a <em>Grid</em> or <em>Table</em> format. Click <em>Settings</em> next to your format type to change the settings for your chosen format.", array());
        echo "</li>
  <li>";
        // line 18
        echo t("When you have finished changing all the settings, verify that the display is correct by clicking <em>Update preview</em>. Return to editing settings if necessary.", array());
        echo "</li>
  <li>";
        // line 19
        echo t("When you have verified the display, click <em>Save</em>. Alternatively, if you have made mistakes and want to discard your changes, click <em>Cancel</em>.", array());
        echo "</li>
</ol>
<h2>";
        // line 21
        echo t("Additional resources", array());
        echo "</h2>
<ul>
  <li>";
        // line 23
        echo t("<a href=\"https://www.drupal.org/docs/user_guide/en/views-chapter.html\">Views chapter in the User Guide</a>", array());
        echo "</li>
</ul>";
    }

    public function getTemplateName()
    {
        return "@help_topics/views_ui.edit.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 23,  86 => 21,  81 => 19,  77 => 18,  73 => 17,  69 => 16,  65 => 15,  61 => 14,  57 => 13,  52 => 11,  48 => 10,  43 => 9,  41 => 8,  39 => 7,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/views_ui.edit.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\TheamDebug\\web\\core\\modules\\help_topics\\help_topics\\views_ui.edit.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 7, "trans" => 9);
        static $filters = array("escape" => 13);
        static $functions = array("render_var" => 7, "url" => 7, "help_topic_link" => 8);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'trans'],
                ['escape'],
                ['render_var', 'url', 'help_topic_link']
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
