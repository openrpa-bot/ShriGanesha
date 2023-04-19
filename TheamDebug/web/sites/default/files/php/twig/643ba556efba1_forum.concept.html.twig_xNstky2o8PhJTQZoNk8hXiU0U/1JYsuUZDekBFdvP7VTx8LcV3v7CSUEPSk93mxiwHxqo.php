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

/* @help_topics/forum.concept.html.twig */
class __TwigTemplate_5a2f69cf1aed6c19f31b9f6d913d8b8d extends \Twig\Template
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
        // line 5
        echo "<h2>";
        echo t("What is a forum?", array());
        echo "</h2>
<p>";
        // line 6
        echo t("A forum is nested hierarchy of discussions, where users post topics and comment on them.", array());
        echo "</p>
<h2>";
        // line 7
        echo t("What is the forum hierarchy?", array());
        echo "</h2>
<p>";
        // line 8
        echo t("The forum hierarchy consists of:", array());
        echo "</p>
<ul>
    <li>";
        // line 10
        echo t("<em>Forums</em> (for example, <em>Recipes for cooking vegetables</em>)", array());
        echo "</li>
    <li>";
        // line 11
        echo t("Optional <em>containers</em> can be used to group similar forums (for example, <em>Recipes</em>). Forums can be inside containers and vice versa.", array());
        echo "</li>
    <li>";
        // line 12
        echo t("<em>Forum topics</em> submitted by users (for example, <em>How to cook potatoes</em>), which start discussions.", array());
        echo "</li>
    <li>";
        // line 13
        echo t("<em>Comments</em> submitted by users (for example, <em>You wash the potatoes first and then...</em>).", array());
        echo "</li>
</ul>
<p>";
        // line 15
        echo t("The <em>forums</em> and <em>containers</em> in the hierarchy are implemented as terms in a hierarchical taxonomy vocabulary. The topics are content items posted in forums (not in containers), and replies are comments on each topic item. Deeply nested hierarchies of forums and containers are generally difficult for users to understand and navigate, so it is recommended to keep your hierarchy simple.", array());
        echo "</p>
<h2>";
        // line 16
        echo t("Managing and using forums overview", array());
        echo "</h2>
<p>";
        // line 17
        echo t("The core Forum module supplies a content type called <em>Forum topic</em>, along with associated comment type and taxonomy vocabulary. As with other comment types, you can configure comments on forum topics to be threaded or unthreaded. See the related topics listed below for specific tasks.", array());
        echo "</p>";
    }

    public function getTemplateName()
    {
        return "@help_topics/forum.concept.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 17,  78 => 16,  74 => 15,  69 => 13,  65 => 12,  61 => 11,  57 => 10,  52 => 8,  48 => 7,  44 => 6,  39 => 5,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/forum.concept.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\TheamDebug\\web\\core\\modules\\help_topics\\help_topics\\forum.concept.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("trans" => 5);
        static $filters = array();
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['trans'],
                [],
                []
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
