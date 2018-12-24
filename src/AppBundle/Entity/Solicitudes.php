<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Solicitudes
 *
 * @ORM\Table(name="solicitudes", indexes={@ORM\Index(name="IDX_216D11013BA3729", columns={"cantidadesbeneficio_id"}), @ORM\Index(name="IDX_216D110BAA72B5A", columns={"idcantidadesbeneficioinst"}), @ORM\Index(name="IDX_216D1109E157E4C", columns={"idestadocivil"}), @ORM\Index(name="IDX_216D110AE4B0437", columns={"idGrado"}), @ORM\Index(name="IDX_216D110139F7671", columns={"idingreso"}), @ORM\Index(name="IDX_216D110B4FB73C", columns={"idmotivodeuda"}), @ORM\Index(name="IDX_216D11053B72D2C", columns={"idparentesco"}), @ORM\Index(name="IDX_216D110EF075161", columns={"idpersonacargo"}), @ORM\Index(name="IDX_216D11079D71D30", columns={"idpoblacionbeneficia"}), @ORM\Index(name="IDX_216D11070C5A4CE", columns={"idseccional"}), @ORM\Index(name="IDX_216D110E9FCC173", columns={"idsituacionvivienda"}), @ORM\Index(name="IDX_216D110174D74B2", columns={"idtiposolicitud"}), @ORM\Index(name="IDX_216D11069A00F34", columns={"idviabilidadplaneacion"}), @ORM\Index(name="IDX_216D110AA18F2E4", columns={"idzonaubicacion"}), @ORM\Index(name="fk_Solicitudes_Seccionales1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_Parentescos1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_Grados1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_Programas1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_TiposSolicitud1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_EstadosCiviles1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_Ingresos1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_PersonasCargo1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_SituacionesVivienda1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_MotivosDeuda1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_CantidadesBeneficio1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_ConceptosVisita1_idx", columns={"idConceptoVisita"}), @ORM\Index(name="fk_Solicitudes_CantidadesBeneficioInst1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_ViabilidadPlaneacion1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_ZonasUbicacion1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_PoblacionBeneficia1_idx", columns={"id"}), @ORM\Index(name="fk_Solicitudes_AfiliadoDibie1_idx", columns={"idAfiliadoDibie"})})
 * @ORM\Entity
 */
class Solicitudes {

    public function __toString() {
        return $this->getId() ? $this->getId() . "" : "";
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="SolicitudFecha", type="date", nullable=true)
     */
    private $solicitudfecha;

    /**
     * @var string
     *
     * @ORM\Column(name="SolicitudCedulaSolicita", type="string", length=45, nullable=true)
     */
    private $solicitudcedulasolicita;

    /**
     * @var string
     *
     * @ORM\Column(name="emailSolicitante", type="string", length=45, nullable=true)
     */
    private $emailSolicitante;

    /**
     * @var string
     *
     * @ORM\Column(name="documentoBeneficiarioFinal", type="string", length=45, nullable=true)
     */
    private $documentoBeneficiarioFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreBeneficiarioFinal", type="string", length=45, nullable=true)
     */
    private $nombreBeneficiarioFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="SolicitudNombreSolicita", type="string", length=300, nullable=true)
     */
    private $solicitudnombresolicita;

    /**
     * @var string
     *
     * @ORM\Column(name="SolicitudCedulaFuncionario", type="string", length=45, nullable=true)
     */
    private $solicitudcedulafuncionario;

    /**
     * @var string
     *
     * @ORM\Column(name="SolicitudDireccionFuncionario", type="string", length=350, nullable=true)
     */
    private $solicituddireccionfuncionario;

    /**
     * @var string
     *
     * @ORM\Column(name="SolicitudTelefonosFuncionario", type="string", length=45, nullable=true)
     */
    private $solicitudtelefonosfuncionario;

    /**
     * @var string
     *
     * @ORM\Column(name="SolicitudNombreFuncionario", type="string", length=450, nullable=true)
     */
    private $solicitudnombrefuncionario;

    /**
     * @var string
     *
     * @ORM\Column(name="SolicitudDescripcion", type="text", nullable=true)
     */
    private $solicituddescripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad_solicitada", type="integer", nullable=true)
     */
    private $cantidadSolicitada;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad_aprobada", type="integer", nullable=true)
     */
    private $cantidadAprobada;

    /**
     * @var \Ingresos
     *
     * @ORM\ManyToOne(targetEntity="Ingresos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idingreso", referencedColumnName="id")
     * })
     */
    public $idingreso;

    /**
     * @var \Cantidadesbeneficio
     *
     * @ORM\ManyToOne(targetEntity="Cantidadesbeneficio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cantidadesbeneficio_id", referencedColumnName="id")
     * })
     */
    private $cantidadesbeneficio;

    /**
     * @var \Tipossolicitud
     *
     * @ORM\ManyToOne(targetEntity="Tipossolicitud")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idtiposolicitud", referencedColumnName="id")
     * })
     */
    public $idtiposolicitud;

    /**
     * @var int
     *
     * @ORM\Column(name="totalPuntaje", type="integer", nullable=true)
     */
    private $totalPuntaje;

    /**
     * @var \Conceptosvisita
     *
     * @ORM\ManyToOne(targetEntity="Conceptosvisita")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idConceptoVisita", referencedColumnName="idConceptoVisita")
     * })
     */
    private $idconceptovisita;

    /**
     * @var \Parentescos
     *
     * @ORM\ManyToOne(targetEntity="Parentescos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idparentesco", referencedColumnName="id")
     * })
     */
    public $idparentesco;

    /**
     * @var \Viabilidadplaneacion
     *
     * @ORM\ManyToOne(targetEntity="Viabilidadplaneacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idviabilidadplaneacion", referencedColumnName="id")
     * })
     */
    private $idviabilidadplaneacion;

    /**
     * @var \Seccionales
     *
     * @ORM\ManyToOne(targetEntity="Seccionales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idseccional", referencedColumnName="id")
     * })
     */
    private $idseccional;

    /**
     * @var \Afiliadodibie
     *
     * @ORM\ManyToOne(targetEntity="Afiliadodibie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAfiliadoDibie", referencedColumnName="idAfiliadoDibie")
     * })
     */
    private $idafiliadodibie;

    /**
     * @var \Poblacionbeneficia
     *
     * @ORM\ManyToOne(targetEntity="Poblacionbeneficia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idpoblacionbeneficia", referencedColumnName="id")
     * })
     */
    private $idpoblacionbeneficia;

    /**
     * @var \Estadosciviles
     *
     * @ORM\ManyToOne(targetEntity="Estadosciviles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idestadocivil", referencedColumnName="id")
     * })
     */
    public $idestadocivil;

    /**
     * @var \Zonasubicacion
     *
     * @ORM\ManyToOne(targetEntity="Zonasubicacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idzonaubicacion", referencedColumnName="id")
     * })
     */
    private $idzonaubicacion;

    /**
     * @var \Grados
     *
     * @ORM\ManyToOne(targetEntity="Grados")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idGrado", referencedColumnName="id")
     * })
     */
    public $idgrado;

    /**
     * @var \Motivosdeuda
     *
     * @ORM\ManyToOne(targetEntity="Motivosdeuda")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idmotivodeuda", referencedColumnName="id")
     * })
     */
    public $idmotivodeuda;

    /**
     * @var \Cantidadesbeneficioinst
     *
     * @ORM\ManyToOne(targetEntity="Cantidadesbeneficioinst")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcantidadesbeneficioinst", referencedColumnName="id")
     * })
     */
    private $idcantidadesbeneficioinst;

    /**
     * @var \Situacionesvivienda
     *
     * @ORM\ManyToOne(targetEntity="Situacionesvivienda")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idsituacionvivienda", referencedColumnName="id")
     * })
     */
    public $idsituacionvivienda;

    /**
     * @var \Personascargo
     *
     * @ORM\ManyToOne(targetEntity="Personascargo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idpersonacargo", referencedColumnName="id")
     * })
     */
    public $idpersonacargo;

    /**
     * @var \unidad
     *
     * @ORM\ManyToOne(targetEntity="unidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idunidad", referencedColumnName="id")
     * })
     */
    private $unidad;

    /**
     * @ORM\OneToMany(targetEntity="ProgramaSolicitud", mappedBy="solicitud" , cascade={"persist"})
     */
    private $programas;

    /**
     * @Assert\File(
     *      maxSize="8388608",
     *      mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "image/gif",
     *          "application/pdf",
     *          "application/x-pdf"
     *      }
     * )
     */
    private $curriculum;

    /**
     * @Assert\File(
     *      maxSize="5242880",
     *      mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "image/gif",
     *          "application/pdf",
     *          "application/x-pdf"
     *      }
     * )
     */
    private $fotoFile;

    /**
     * @var string
     *
     * @ORM\Column(name="archivo", type="string", length=3000, nullable=true)
     */
    private $archivo;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=3000, nullable=true)
     */
    private $foto;

    /**
     * @var string
     *
     * @ORM\Column(name="ValorBeneficio", type="string", length=45, nullable=true)
     */
    private $ValorBeneficio;

    /**
     * @var string
     *
     * @ORM\Column(name="TiempoBeneficio", type="string", length=45, nullable=true)
     */
    private $TiempoBeneficio;

    /**
     * @var string
     *
     * @ORM\Column(name="ValortotalBeneficio", type="string", length=45, nullable=true)
     */
    private $ValortotalBeneficio;

    /**
     * @var \otorga
     *
     * @ORM\ManyToOne(targetEntity="otorga")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idotorga", referencedColumnName="id")
     * })
     */
    private $otorga;

    /**
     * @var \antiguedad
     *
     * @ORM\ManyToOne(targetEntity="antiguedad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idantiguedad", referencedColumnName="id")
     * })
     */
    private $antiguedad;

    /**
     * @var \concepto
     *
     * @ORM\ManyToOne(targetEntity="Concepto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="concepto_id", referencedColumnName="id")
     * })
     */
    private $concepto;

    /**
     * @var \concepto
     *
     * @ORM\ManyToOne(targetEntity="Concepto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="concepto_final_id", referencedColumnName="id")
     * })
     */
    private $conceptoFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="Acta", type="string", length=45, nullable=true)
     */
    private $Acta;

    /**
     * @ORM\OneToMany(targetEntity="Conceptosjunta", mappedBy="solicitud" , cascade={"persist"})
     */
    private $conceptoJunta;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set solicitudfecha
     *
     * @param \DateTime $solicitudfecha
     *
     * @return Solicitudes
     */
    public function setSolicitudfecha($solicitudfecha) {
        $this->solicitudfecha = $solicitudfecha;

        return $this;
    }

    /**
     * Get solicitudfecha
     *
     * @return \DateTime
     */
    public function getSolicitudfecha() {
        return $this->solicitudfecha;
    }

    /**
     * Set solicitudcedulasolicita
     *
     * @param string $solicitudcedulasolicita
     *
     * @return Solicitudes
     */
    public function setSolicitudcedulasolicita($solicitudcedulasolicita) {
        $this->solicitudcedulasolicita = $solicitudcedulasolicita;

        return $this;
    }

    /**
     * Get solicitudcedulasolicita
     *
     * @return string
     */
    public function getSolicitudcedulasolicita() {
        return $this->solicitudcedulasolicita;
    }

    /**
     * Set solicitudnombresolicita
     *
     * @param string $solicitudnombresolicita
     *
     * @return Solicitudes
     */
    public function setSolicitudnombresolicita($solicitudnombresolicita) {
        $this->solicitudnombresolicita = $solicitudnombresolicita;

        return $this;
    }

    /**
     * Get solicitudnombresolicita
     *
     * @return string
     */
    public function getSolicitudnombresolicita() {
        return $this->solicitudnombresolicita;
    }

    /**
     * Set solicitudcedulafuncionario
     *
     * @param string $solicitudcedulafuncionario
     *
     * @return Solicitudes
     */
    public function setSolicitudcedulafuncionario($solicitudcedulafuncionario) {
        $this->solicitudcedulafuncionario = $solicitudcedulafuncionario;

        return $this;
    }

    /**
     * Get solicitudcedulafuncionario
     *
     * @return string
     */
    public function getSolicitudcedulafuncionario() {
        return $this->solicitudcedulafuncionario;
    }

    /**
     * Set solicituddireccionfuncionario
     *
     * @param string $solicituddireccionfuncionario
     *
     * @return Solicitudes
     */
    public function setSolicituddireccionfuncionario($solicituddireccionfuncionario) {
        $this->solicituddireccionfuncionario = $solicituddireccionfuncionario;

        return $this;
    }

    /**
     * Get solicituddireccionfuncionario
     *
     * @return string
     */
    public function getSolicituddireccionfuncionario() {
        return $this->solicituddireccionfuncionario;
    }

    /**
     * Set solicitudtelefonosfuncionario
     *
     * @param string $solicitudtelefonosfuncionario
     *
     * @return Solicitudes
     */
    public function setSolicitudtelefonosfuncionario($solicitudtelefonosfuncionario) {
        $this->solicitudtelefonosfuncionario = $solicitudtelefonosfuncionario;

        return $this;
    }

    /**
     * Get solicitudtelefonosfuncionario
     *
     * @return string
     */
    public function getSolicitudtelefonosfuncionario() {
        return $this->solicitudtelefonosfuncionario;
    }

    /**
     * Set solicitudnombrefuncionario
     *
     * @param string $solicitudnombrefuncionario
     *
     * @return Solicitudes
     */
    public function setSolicitudnombrefuncionario($solicitudnombrefuncionario) {
        $this->solicitudnombrefuncionario = $solicitudnombrefuncionario;

        return $this;
    }

    /**
     * Get solicitudnombrefuncionario
     *
     * @return string
     */
    public function getSolicitudnombrefuncionario() {
        return $this->solicitudnombrefuncionario;
    }

    /**
     * Set solicituddescripcion
     *
     * @param string $solicituddescripcion
     *
     * @return Solicitudes
     */
    public function setSolicituddescripcion($solicituddescripcion) {
        $this->solicituddescripcion = $solicituddescripcion;

        return $this;
    }

    /**
     * Get solicituddescripcion
     *
     * @return string
     */
    public function getSolicituddescripcion() {
        return $this->solicituddescripcion;
    }

    /**
     * Set idingreso
     *
     * @param \AppBundle\Entity\Ingresos $idingreso
     *
     * @return Solicitudes
     */
    public function setIdingreso(\AppBundle\Entity\Ingresos $idingreso = null) {
        $this->idingreso = $idingreso;

        return $this;
    }

    /**
     * Get idingreso
     *
     * @return \AppBundle\Entity\Ingresos
     */
    public function getIdingreso() {
        return $this->idingreso;
    }

    /**
     * Set cantidadesbeneficio
     *
     * @param \AppBundle\Entity\Cantidadesbeneficio $cantidadesbeneficio
     *
     * @return Solicitudes
     */
    public function setCantidadesbeneficio(\AppBundle\Entity\Cantidadesbeneficio $cantidadesbeneficio = null) {
        $this->cantidadesbeneficio = $cantidadesbeneficio;

        return $this;
    }

    /**
     * Get cantidadesbeneficio
     *
     * @return \AppBundle\Entity\Cantidadesbeneficio
     */
    public function getCantidadesbeneficio() {
        return $this->cantidadesbeneficio;
    }

    /**
     * Set idtiposolicitud
     *
     * @param \AppBundle\Entity\Tipossolicitud $idtiposolicitud
     *
     * @return Solicitudes
     */
    public function setIdtiposolicitud(\AppBundle\Entity\Tipossolicitud $idtiposolicitud = null) {
        $this->idtiposolicitud = $idtiposolicitud;

        return $this;
    }

    /**
     * Get idtiposolicitud
     *
     * @return \AppBundle\Entity\Tipossolicitud
     */
    public function getIdtiposolicitud() {
        return $this->idtiposolicitud;
    }

    /**
     * Set idconceptovisita
     *
     * @param \AppBundle\Entity\Conceptosvisita $idconceptovisita
     *
     * @return Solicitudes
     */
    public function setIdconceptovisita(\AppBundle\Entity\Conceptosvisita $idconceptovisita = null) {
        $this->idconceptovisita = $idconceptovisita;

        return $this;
    }

    /**
     * Get idconceptovisita
     *
     * @return \AppBundle\Entity\Conceptosvisita
     */
    public function getIdconceptovisita() {
        return $this->idconceptovisita;
    }

    /**
     * Set idparentesco
     *
     * @param \AppBundle\Entity\Parentescos $idparentesco
     *
     * @return Solicitudes
     */
    public function setIdparentesco(\AppBundle\Entity\Parentescos $idparentesco = null) {
        $this->idparentesco = $idparentesco;

        return $this;
    }

    /**
     * Get idparentesco
     *
     * @return \AppBundle\Entity\Parentescos
     */
    public function getIdparentesco() {
        return $this->idparentesco;
    }

    /**
     * Set idviabilidadplaneacion
     *
     * @param \AppBundle\Entity\Viabilidadplaneacion $idviabilidadplaneacion
     *
     * @return Solicitudes
     */
    public function setIdviabilidadplaneacion(\AppBundle\Entity\Viabilidadplaneacion $idviabilidadplaneacion = null) {
        $this->idviabilidadplaneacion = $idviabilidadplaneacion;

        return $this;
    }

    /**
     * Get idviabilidadplaneacion
     *
     * @return \AppBundle\Entity\Viabilidadplaneacion
     */
    public function getIdviabilidadplaneacion() {
        return $this->idviabilidadplaneacion;
    }

    /**
     * Set idseccional
     *
     * @param \AppBundle\Entity\Seccionales $idseccional
     *
     * @return Solicitudes
     */
    public function setIdseccional(\AppBundle\Entity\Seccionales $idseccional = null) {
        $this->idseccional = $idseccional;

        return $this;
    }

    /**
     * Get idseccional
     *
     * @return \AppBundle\Entity\Seccionales
     */
    public function getIdseccional() {
        return $this->idseccional;
    }

    /**
     * Set idafiliadodibie
     *
     * @param \AppBundle\Entity\Afiliadodibie $idafiliadodibie
     *
     * @return Solicitudes
     */
    public function setIdafiliadodibie(\AppBundle\Entity\Afiliadodibie $idafiliadodibie = null) {
        $this->idafiliadodibie = $idafiliadodibie;

        return $this;
    }

    /**
     * Get idafiliadodibie
     *
     * @return \AppBundle\Entity\Afiliadodibie
     */
    public function getIdafiliadodibie() {
        return $this->idafiliadodibie;
    }

    /**
     * Set idpoblacionbeneficia
     *
     * @param \AppBundle\Entity\Poblacionbeneficia $idpoblacionbeneficia
     *
     * @return Solicitudes
     */
    public function setIdpoblacionbeneficia(\AppBundle\Entity\Poblacionbeneficia $idpoblacionbeneficia = null) {
        $this->idpoblacionbeneficia = $idpoblacionbeneficia;

        return $this;
    }

    /**
     * Get idpoblacionbeneficia
     *
     * @return \AppBundle\Entity\Poblacionbeneficia
     */
    public function getIdpoblacionbeneficia() {
        return $this->idpoblacionbeneficia;
    }

    /**
     * Set idestadocivil
     *
     * @param \AppBundle\Entity\Estadosciviles $idestadocivil
     *
     * @return Solicitudes
     */
    public function setIdestadocivil(\AppBundle\Entity\Estadosciviles $idestadocivil = null) {
        $this->idestadocivil = $idestadocivil;

        return $this;
    }

    /**
     * Get idestadocivil
     *
     * @return \AppBundle\Entity\Estadosciviles
     */
    public function getIdestadocivil() {
        return $this->idestadocivil;
    }

    /**
     * Set idzonaubicacion
     *
     * @param \AppBundle\Entity\Zonasubicacion $idzonaubicacion
     *
     * @return Solicitudes
     */
    public function setIdzonaubicacion(\AppBundle\Entity\Zonasubicacion $idzonaubicacion = null) {
        $this->idzonaubicacion = $idzonaubicacion;

        return $this;
    }

    /**
     * Get idzonaubicacion
     *
     * @return \AppBundle\Entity\Zonasubicacion
     */
    public function getIdzonaubicacion() {
        return $this->idzonaubicacion;
    }

    /**
     * Set idgrado
     *
     * @param \AppBundle\Entity\Grados $idgrado
     *
     * @return Solicitudes
     */
    public function setIdgrado(\AppBundle\Entity\Grados $idgrado = null) {
        $this->idgrado = $idgrado;

        return $this;
    }

    /**
     * Get idgrado
     *
     * @return \AppBundle\Entity\Grados
     */
    public function getIdgrado() {
        return $this->idgrado;
    }

    /**
     * Set idmotivodeuda
     *
     * @param \AppBundle\Entity\Motivosdeuda $idmotivodeuda
     *
     * @return Solicitudes
     */
    public function setIdmotivodeuda(\AppBundle\Entity\Motivosdeuda $idmotivodeuda = null) {
        $this->idmotivodeuda = $idmotivodeuda;

        return $this;
    }

    /**
     * Get idmotivodeuda
     *
     * @return \AppBundle\Entity\Motivosdeuda
     */
    public function getIdmotivodeuda() {
        return $this->idmotivodeuda;
    }

    /**
     * Set idcantidadesbeneficioinst
     *
     * @param \AppBundle\Entity\Cantidadesbeneficioinst $idcantidadesbeneficioinst
     *
     * @return Solicitudes
     */
    public function setIdcantidadesbeneficioinst(\AppBundle\Entity\Cantidadesbeneficioinst $idcantidadesbeneficioinst = null) {
        $this->idcantidadesbeneficioinst = $idcantidadesbeneficioinst;

        return $this;
    }

    /**
     * Get idcantidadesbeneficioinst
     *
     * @return \AppBundle\Entity\Cantidadesbeneficioinst
     */
    public function getIdcantidadesbeneficioinst() {
        return $this->idcantidadesbeneficioinst;
    }

    /**
     * Set idsituacionvivienda
     *
     * @param \AppBundle\Entity\Situacionesvivienda $idsituacionvivienda
     *
     * @return Solicitudes
     */
    public function setIdsituacionvivienda(\AppBundle\Entity\Situacionesvivienda $idsituacionvivienda = null) {
        $this->idsituacionvivienda = $idsituacionvivienda;

        return $this;
    }

    /**
     * Get idsituacionvivienda
     *
     * @return \AppBundle\Entity\Situacionesvivienda
     */
    public function getIdsituacionvivienda() {
        return $this->idsituacionvivienda;
    }

    /**
     * Set idpersonacargo
     *
     * @param \AppBundle\Entity\Personascargo $idpersonacargo
     *
     * @return Solicitudes
     */
    public function setIdpersonacargo(\AppBundle\Entity\Personascargo $idpersonacargo = null) {
        $this->idpersonacargo = $idpersonacargo;

        return $this;
    }

    /**
     * Get idpersonacargo
     *
     * @return \AppBundle\Entity\Personascargo
     */
    public function getIdpersonacargo() {
        return $this->idpersonacargo;
    }

    public function getCurriculum() {
        return $this->curriculum;
    }

    public function setCurriculum($curriculum) {
        $this->curriculum = $curriculum;

        return $this;
    }

    public function getFotoFile() {
        return $this->fotoFile;
    }

    public function setFotoFile($fotoFile) {
        $this->fotoFile = $fotoFile;

        return $this;
    }

    /**
     * Set unidad
     *
     * @param \AppBundle\Entity\Unidad $unidad
     *
     * @return Solicitudes
     */
    public function setUnidad(\AppBundle\Entity\Unidad $unidad = null) {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return \AppBundle\Entity\Unidad
     */
    public function getUnidad() {
        return $this->unidad;
    }

    /**
     * Set totalPuntaje
     *
     * @param integer $totalPuntaje
     *
     * @return Solicitudes
     */
    public function setTotalPuntaje($totalPuntaje) {
        $this->totalPuntaje = $totalPuntaje;

        return $this;
    }

    /**
     * Get totalPuntaje
     *
     * @return integer
     */
    public function getTotalPuntaje() {
        return $this->totalPuntaje;
    }

    /**
     * Set archivo
     *
     * @param string $archivo
     *
     * @return Solicitudes
     */
    public function setArchivo($archivo) {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Get archivo
     *
     * @return string
     */
    public function getArchivo() {
        return $this->archivo;
    }

    /**
     * Set valorBeneficio
     *
     * @param string $valorBeneficio
     *
     * @return Solicitudes
     */
    public function setValorBeneficio($valorBeneficio) {
        $this->ValorBeneficio = $valorBeneficio;

        return $this;
    }

    /**
     * Get valorBeneficio
     *
     * @return string
     */
    public function getValorBeneficio() {
        return $this->ValorBeneficio;
    }

    /**
     * Set tiempoBeneficio
     *
     * @param string $tiempoBeneficio
     *
     * @return Solicitudes
     */
    public function setTiempoBeneficio($tiempoBeneficio) {
        $this->TiempoBeneficio = $tiempoBeneficio;

        return $this;
    }

    /**
     * Get tiempoBeneficio
     *
     * @return string
     */
    public function getTiempoBeneficio() {
        return $this->TiempoBeneficio;
    }

    /**
     * Set valortotalBeneficio
     *
     * @param string $valortotalBeneficio
     *
     * @return Solicitudes
     */
    public function setValortotalBeneficio($valortotalBeneficio) {
        $this->ValortotalBeneficio = $valortotalBeneficio;

        return $this;
    }

    /**
     * Get valortotalBeneficio
     *
     * @return string
     */
    public function getValortotalBeneficio() {
        return $this->ValortotalBeneficio;
    }

    /**
     * Set otorga
     *
     * @param \AppBundle\Entity\otorga $otorga
     *
     * @return Solicitudes
     */
    public function setOtorga(\AppBundle\Entity\otorga $otorga = null) {
        $this->otorga = $otorga;

        return $this;
    }

    /**
     * Get otorga
     *
     * @return \AppBundle\Entity\otorga
     */
    public function getOtorga() {
        return $this->otorga;
    }

    /**
     * Set antiguedad
     *
     * @param \AppBundle\Entity\antiguedad $antiguedad
     *
     * @return Solicitudes
     */
    public function setAntiguedad(\AppBundle\Entity\antiguedad $antiguedad = null) {
        $this->antiguedad = $antiguedad;

        return $this;
    }

    /**
     * Get antiguedad
     *
     * @return \AppBundle\Entity\antiguedad
     */
    public function getAntiguedad() {
        return $this->antiguedad;
    }

    /**
     * Set acta
     *
     * @param string $acta
     *
     * @return Solicitudes
     */
    public function setActa($acta) {
        $this->Acta = $acta;

        return $this;
    }

    /**
     * Get acta
     *
     * @return string
     */
    public function getActa() {
        return $this->Acta;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->programas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * set programas
     *
     * @param \AppBundle\Entity\ProgramaSolicitud $programa
     *
     * @return Solicitudes
     */
    public function setProgramas($programas) {
        $this->programas = null;

        return $this;
    }

    /**
     * Add programa
     *
     * @param \AppBundle\Entity\ProgramaSolicitud $programa
     *
     * @return Solicitudes
     */
    public function addPrograma(\AppBundle\Entity\ProgramaSolicitud $programa) {
        $this->programas[] = $programa;

        return $this;
    }

    /**
     * Remove programa
     *
     * @param \AppBundle\Entity\ProgramaSolicitud $programa
     */
    public function removePrograma(\AppBundle\Entity\ProgramaSolicitud $programa) {
        $this->programas->removeElement($programa);
    }

    /**
     * Get programas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgramas() {
        return $this->programas;
    }

    /**
     * Set documentoBeneficiarioFinal
     *
     * @param string $documentoBeneficiarioFinal
     *
     * @return Solicitudes
     */
    public function setDocumentoBeneficiarioFinal($documentoBeneficiarioFinal) {
        $this->documentoBeneficiarioFinal = $documentoBeneficiarioFinal;

        return $this;
    }

    /**
     * Get documentoBeneficiarioFinal
     *
     * @return string
     */
    public function getDocumentoBeneficiarioFinal() {
        return $this->documentoBeneficiarioFinal;
    }

    /**
     * Set nombreBeneficiarioFinal
     *
     * @param string $nombreBeneficiarioFinal
     *
     * @return Solicitudes
     */
    public function setNombreBeneficiarioFinal($nombreBeneficiarioFinal) {
        $this->nombreBeneficiarioFinal = $nombreBeneficiarioFinal;

        return $this;
    }

    /**
     * Get nombreBeneficiarioFinal
     *
     * @return string
     */
    public function getNombreBeneficiarioFinal() {
        return $this->nombreBeneficiarioFinal;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Solicitudes
     */
    public function setFoto($foto) {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto() {
        return $this->foto;
    }

    /**
     * Set emailSolicitante
     *
     * @param string $emailSolicitante
     *
     * @return Solicitudes
     */
    public function setEmailSolicitante($emailSolicitante) {
        $this->emailSolicitante = $emailSolicitante;

        return $this;
    }

    /**
     * Get emailSolicitante
     *
     * @return string
     */
    public function getEmailSolicitante() {
        return $this->emailSolicitante;
    }

    /**
     * Set concepto
     *
     * @param \AppBundle\Entity\Concepto $concepto
     *
     * @return Solicitudes
     */
    public function setConcepto(\AppBundle\Entity\Concepto $concepto = null) {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return \AppBundle\Entity\Concepto
     */
    public function getConcepto() {
        return $this->concepto;
    }

    /**
     * Set cantidadSolicitada
     *
     * @param integer $cantidadSolicitada
     *
     * @return Solicitudes
     */
    public function setCantidadSolicitada($cantidadSolicitada) {
        $this->cantidadSolicitada = $cantidadSolicitada;

        return $this;
    }

    /**
     * Get cantidadSolicitada
     *
     * @return integer
     */
    public function getCantidadSolicitada() {
        return $this->cantidadSolicitada;
    }

    /**
     * Set cantidadAprobada
     *
     * @param integer $cantidadAprobada
     *
     * @return Solicitudes
     */
    public function setCantidadAprobada($cantidadAprobada) {
        $this->cantidadAprobada = $cantidadAprobada;

        return $this;
    }

    /**
     * Get cantidadAprobada
     *
     * @return integer
     */
    public function getCantidadAprobada() {
        return $this->cantidadAprobada;
    }

    /**
     * Set conceptoFinal
     *
     * @param \AppBundle\Entity\Concepto $conceptoFinal
     *
     * @return Solicitudes
     */
    public function setConceptoFinal(\AppBundle\Entity\Concepto $conceptoFinal = null) {
        $this->conceptoFinal = $conceptoFinal;

        return $this;
    }

    /**
     * Get conceptoFinal
     *
     * @return \AppBundle\Entity\Concepto
     */
    public function getConceptoFinal() {
        return $this->conceptoFinal;
    }

    /**
     * Add conceptoJuntum
     *
     * @param \AppBundle\Entity\Conceptosjunta $conceptoJuntum
     *
     * @return Solicitudes
     */
    public function addConceptoJuntum(\AppBundle\Entity\Conceptosjunta $conceptoJuntum) {
        $this->conceptoJunta[] = $conceptoJuntum;

        return $this;
    }

    /**
     * Remove conceptoJuntum
     *
     * @param \AppBundle\Entity\Conceptosjunta $conceptoJuntum
     */
    public function removeConceptoJuntum(\AppBundle\Entity\Conceptosjunta $conceptoJuntum) {
        $this->conceptoJunta->removeElement($conceptoJuntum);
    }

    /**
     * Get conceptoJunta
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConceptoJunta() {
        return $this->conceptoJunta;
    }

    protected $programasArray;

    public function getProgramasArray() {
        foreach ($this->getProgramas() as $prog) {
            $this->programasArray .= $prog->getPrograma()->getProgramanombre() . "<br>";
        }
        return $this->programasArray;
    }

}
