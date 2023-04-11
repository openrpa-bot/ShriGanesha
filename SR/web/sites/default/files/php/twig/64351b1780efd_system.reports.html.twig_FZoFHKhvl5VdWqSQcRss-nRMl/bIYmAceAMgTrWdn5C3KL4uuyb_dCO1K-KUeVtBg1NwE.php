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

/* @help_topics/system.reports.html.twig */
class __TwigTemplate_6f5732644818e04654e922a03b1c5d1c extends \Twig\Template
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
        $context["status_url"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getUrl("system.status"));
        // line 9
        echo "<h2>";
        echo t("Goal", array());
        echo "</h2>
<p>";
        // line 10
        echo t("Run reports to learn about the status and health of your site.", array());
        echo "</p>
<h2>";
        // line 11
        echo t("Steps", array());
        echo "</h2>
<ol>
  <li>";
        // line 13
        echo t("In the <em>Manage</em> administrative menu, navigate to <em>Reports</em> &gt; <a href=\"@status_url\"><em>Status report</em></a> to see a report that summarizes the health and status of your site. If there are any warnings or errors, you will need to fix them. Take note of any upcoming highly critical security releases that may impact your site.", array("@status_url" => ($context["status_url"] ?? null), ));
        echo "</li>
  <li>";
        // line 14
        echo t("If you have the core Database Logging module installed, in the <em>Manage</em> administrative menu, navigate to <em>Reports</em> &gt; <em>Recent log messages</em> to see a report of the error and informational messages your site has generated. You can filter the report by <em>Severity</em> to see only the most critical messages, if desired.", array());
        echo "</li>
  <li>";
        // line 15
        echo t("If you have the core Update Manager module installed, in the <em>Manage</em> administrative menu, navigate to <em>Reports</em> &gt; <em>Available updates</em> to see a report of the updates that are available for your site software. If <em>Last checked</em> is far in the past, click <em>Check manually</em> to update the report. Scan the report; if Drupal core or any modules or themes have security updates available, you should update them as soon as possible.", array());
        echo "</li>
</ol>
<h2>";
        // line 17
        echo t("Additional resources", array());
        echo "</h2>
<ul>
    <li>";
        // line 19
        echo t("<a href=\"https://www.drupal.org/docs/user_guide/en/security-chapter.html\">Security and Maintenance chapter in the User Guide</a>, which includes information on how to update your site's core software, modules, and themes", array());
        echo "</li>
</ul>";
    }

    public function getTemplateName()
    {
        return "@help_topics/system.reports.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 19,  68 => 17,  63 => 15,  59 => 14,  55 => 13,  50 => 11,  46 => 10,  41 => 9,  39 => 8,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/system.reports.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\SR\\web\\core\\modules\\help_topics\\help_topics\\system.reports.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 8, "trans" => 9);
        static $filters = array("escape" => 13);
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
