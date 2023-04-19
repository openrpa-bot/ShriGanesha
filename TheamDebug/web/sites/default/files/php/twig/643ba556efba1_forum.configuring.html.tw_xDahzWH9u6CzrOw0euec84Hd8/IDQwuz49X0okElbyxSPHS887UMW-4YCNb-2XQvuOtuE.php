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

/* @help_topics/forum.configuring.html.twig */
class __TwigTemplate_3467aa7e89f61af27f5f92453a643e2c extends \Twig\Template
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
        $context["forum_concept_topic"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getTopicLink("forum.concept"));
        // line 7
        ob_start(function () { return ''; });
        echo t("Settings", array());
        $context["settings_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 8
        $context["settings_link"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["settings_link_text"] ?? null), 8, $this->source), "forum.settings"));
        // line 9
        ob_start(function () { return ''; });
        echo t("Forums", array());
        $context["overview_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 10
        $context["overview_link"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["overview_link_text"] ?? null), 10, $this->source), "forum.overview"));
        // line 11
        ob_start(function () { return ''; });
        echo t("Forums", array());
        $context["index_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 12
        $context["index_link"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["index_link_text"] ?? null), 12, $this->source), "forum.index"));
        // line 13
        echo "<h2>";
        echo t("Goal", array());
        echo "</h2>
<p>";
        // line 14
        echo t("Configure settings for forums, and set up forum structure.", array());
        echo "</p>
<h2>";
        // line 15
        echo t("Steps", array());
        echo "</h2>
<ol>
  <li>";
        // line 17
        echo t("In the <em>Manage</em> administrative menu, navigate to <em>Structure</em> &gt; <em>Forums</em> &gt; <em>@settings_link</em>.", array("@settings_link" => ($context["settings_link"] ?? null), ));
        echo "</li>
  <li>";
        // line 18
        echo t("Choose the desired settings for <em>Hot topic threshold</em>, <em>Topics per page</em>, and <em>Default order</em>. Click <em>Save configuration</em> if you have made any changes.", array());
        echo "</li>
  <li>";
        // line 19
        echo t("In the <em>Manage</em> administrative menu, navigate to <em>Structure</em> &gt; <em>@overview_link</em>.", array("@overview_link" => ($context["overview_link"] ?? null), ));
        echo "</li>
  <li>";
        // line 20
        echo t("Decide on the hierarchy of containers and forums you want for your site; see @forum_concept_topic for an overview of forum hierarchy.", array("@forum_concept_topic" => ($context["forum_concept_topic"] ?? null), ));
        echo "</li>
  <li>";
        // line 21
        echo t("Create the containers that you want in your forum hierarchy, starting at the top level, if any. To create a container, click <em>Add container</em>, enter the container name and optionally other settings, and click <em>Save</em>.", array());
        echo "</li>
  <li>";
        // line 22
        echo t("Create the forums that you want in your forum hierarchy, starting at the top level. To create a forum, click <em>Add forum</em> and enter the forum name. If your hierarchy has this forum inside a container or another forum, select the parent forum/container in the <em>Parent</em> field. Review and/or edit the other settings, and click <em>Save</em>.", array());
        echo "</li>
  <li>";
        // line 23
        echo t("Optionally, delete the provided <em>General discussion</em> forum, if you do not want this forum to be available on your site.", array());
        echo "</li>
  <li>";
        // line 24
        echo t("Review and/or edit the permissions related to forums. The administrative permission for editing the forum settings is in the <em>Forum</em> module section of the permissions page, and administrative permissions for editing the forum hierarchy are in the <em>Taxonomy</em> module section. The user permissions for creating forum topics are in the <em>Node</em> module section, and for commenting on topics are in the <em>Comment</em> module section.", array());
        echo "</li>
  <li>";
        // line 25
        echo t("Add links to the main <em>@index_link</em> page (path: <em>/forum</em>), and optionally to individual forum pages, to navigation menus on your site, so that users can find the forums.", array("@index_link" => ($context["index_link"] ?? null), ));
        echo "</li>
</ol>";
    }

    public function getTemplateName()
    {
        return "@help_topics/forum.configuring.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 25,  101 => 24,  97 => 23,  93 => 22,  89 => 21,  85 => 20,  81 => 19,  77 => 18,  73 => 17,  68 => 15,  64 => 14,  59 => 13,  57 => 12,  53 => 11,  51 => 10,  47 => 9,  45 => 8,  41 => 7,  39 => 6,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/forum.configuring.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\TheamDebug\\web\\core\\modules\\help_topics\\help_topics\\forum.configuring.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 6, "trans" => 7);
        static $filters = array("escape" => 17);
        static $functions = array("render_var" => 6, "help_topic_link" => 6, "help_route_link" => 8);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'trans'],
                ['escape'],
                ['render_var', 'help_topic_link', 'help_route_link']
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
