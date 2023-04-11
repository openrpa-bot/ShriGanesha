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

/* @help_topics/forum.locking.html.twig */
class __TwigTemplate_8a1b88d23c199fd93c450697d616687f extends \Twig\Template
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
        ob_start(function () { return ''; });
        echo t("Forums", array());
        $context["index_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 7
        $context["index_link"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["index_link_text"] ?? null), 7, $this->source), "forum.index"));
        // line 8
        echo "<h2>";
        echo t("Goal", array());
        echo "</h2>
<p>";
        // line 9
        echo t("Lock a topic to prevent users from making any more comments.", array());
        echo "</p>
<h2>";
        // line 10
        echo t("Steps", array());
        echo "</h2>
<ol>
  <li>";
        // line 12
        echo t("Starting from @index_link (path: <em>/forums</em>), navigate to the forum that currently contains the topic.", array("@index_link" => ($context["index_link"] ?? null), ));
        echo "</li>
  <li>";
        // line 13
        echo t("Locate the topic within the forum, and click on the title to view the topic.", array());
        echo "</li>
  <li>";
        // line 14
        echo t("Click <em>Edit</em>.", array());
        echo "</li>
  <li>";
        // line 15
        echo t("Under <em>Comment settings</em>, check <em>Closed</em>.", array());
        echo "</li>
  <li>";
        // line 16
        echo t("Click <em>Save</em>.", array());
        echo "</li>
</ol>";
    }

    public function getTemplateName()
    {
        return "@help_topics/forum.locking.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 16,  71 => 15,  67 => 14,  63 => 13,  59 => 12,  54 => 10,  50 => 9,  45 => 8,  43 => 7,  39 => 6,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/forum.locking.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\SR\\web\\core\\modules\\help_topics\\help_topics\\forum.locking.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 6, "trans" => 6);
        static $filters = array("escape" => 12);
        static $functions = array("render_var" => 7, "help_route_link" => 7);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'trans'],
                ['escape'],
                ['render_var', 'help_route_link']
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
