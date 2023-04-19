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

/* @help_topics/views_ui.bulk_operations.html.twig */
class __TwigTemplate_37cec9025483745e95f158469f722db0 extends \Twig\Template
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
        // line 10
        ob_start(function () { return ''; });
        // line 11
        echo "  ";
        echo t("Views", array());
        $context["views_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 13
        $context["views"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["views_link_text"] ?? null), 13, $this->source), "entity.view.collection"));
        // line 14
        ob_start(function () { return ''; });
        // line 15
        echo "  ";
        echo t("Administer views", array());
        $context["views_permissions_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 17
        $context["views_permissions"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["views_permissions_link_text"] ?? null), 17, $this->source), "user.admin_permissions.module", ["modules" => "views_ui"]));
        // line 18
        echo "<h2>";
        echo t("Goal", array());
        echo "</h2>
<p>";
        // line 19
        echo t("Add one or more existing actions as bulk operations to an existing table-style view. If you have the core Actions module installed, see the related topic \"Configuring actions\" for more information about actions.", array());
        echo "</p>
<h2>";
        // line 20
        echo t("Who can edit views?", array());
        echo "</h2>
<p>";
        // line 21
        echo t("The core Views UI module will need to be installed and you will need <em>@views_permissions</em> permission in order to edit a view.", array("@views_permissions" => ($context["views_permissions"] ?? null), ));
        echo "</p>
<h2>";
        // line 22
        echo t("Steps", array());
        echo "</h2>
<ol>
  <li>";
        // line 24
        echo t("In the <em>Manage</em> administrative menu, navigate to <em>Structure</em> &gt; <em>@views</em>. A list of all views is shown.", array("@views" => ($context["views"] ?? null), ));
        echo "</li>
  <li>";
        // line 25
        echo t("Find the view that you would like to edit, and click <em>Edit</em> from the dropdown button. Note that bulk operations work best in a view with a Page display, and a Table format.", array());
        echo "</li>
  <li>";
        // line 26
        echo t("If there is not already an <em>Operations bulk form</em> in the <em>Fields</em> list for the view, click <em>Add</em> in the <em>Fields</em> section to add it. (The exact name of the bulk form field will vary, and may contain keywords like \"bulk update\", \"form element\" or \"operations\" -- not to be confused with <em>operations links</em>, which are applied to each item in a row.) If the bulk operations field already exists, click the field name to edit its settings.", array());
        echo "</li>
  <li>";
        // line 27
        echo t("Check the action(s) you want to make available in the <em>Selected actions</em> list and click <em>Apply (all displays)</em>.", array());
        echo "</li>
  <li>";
        // line 28
        echo t("Verify that the <em>Access</em> settings for the view are at least as restrictive as the permissions necessary to perform the bulk operations. People with permission to see the view, but who don't have permission to do the bulk operations, will experience problems.", array());
        echo "</li>
  <li>";
        // line 29
        echo t("Click <em>Save</em>. The action(s) will be available as bulk operations in the view.", array());
        echo "</li>
</ol>";
    }

    public function getTemplateName()
    {
        return "@help_topics/views_ui.bulk_operations.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  97 => 29,  93 => 28,  89 => 27,  85 => 26,  81 => 25,  77 => 24,  72 => 22,  68 => 21,  64 => 20,  60 => 19,  55 => 18,  53 => 17,  49 => 15,  47 => 14,  45 => 13,  41 => 11,  39 => 10,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/views_ui.bulk_operations.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\TheamDebug\\web\\core\\modules\\help_topics\\help_topics\\views_ui.bulk_operations.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 10, "trans" => 11);
        static $filters = array("escape" => 21);
        static $functions = array("render_var" => 13, "help_route_link" => 13);

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
